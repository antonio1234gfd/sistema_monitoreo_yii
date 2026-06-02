<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\Cors;
use common\models\LecturasSensores;
use common\models\AlertasHistorial;
use common\models\UmbralesConfiguracion;

class SensorController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow'   => true,
                    'actions' => ['recibir', 'ultima', 'umbrales', 'historial'],
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'recibir'  => ['POST'],
                'ultima'   => ['GET'],
                'umbrales' => ['GET'],
                'historial' => ['GET'],
            ],
        ];

        return $behaviors;
    }

    public function actionHistorial($id = 1, $limite = 20)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $lecturas = LecturasSensores::find()
            ->where(['id_dispositivo' => $id])
            ->orderBy(['fecha_hora' => SORT_DESC])
            ->limit($limite)
            ->all();

        $data = array_map(function($l) {
            return [
                'mq135'      => (float)$l->mq135_valor,
                'mq5'        => (float)$l->mq5_valor,
                'fecha_hora' => $l->fecha_hora,
            ];
        }, $lecturas);

        return ['ok' => true, 'data' => array_reverse($data)];
    }

    public function actionRecibir()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();

        if (empty($post['id_dispositivo']) || !isset($post['mq135'])) {
            Yii::$app->response->statusCode = 400;
            return ['ok' => false, 'error' => 'Faltan datos'];
        }

        $lectura = new LecturasSensores();
        $lectura->id_dispositivo    = (int)   $post['id_dispositivo'];
        $lectura->mq135_valor       = (float) $post['mq135'];
        $lectura->mq5_valor         = (float) ($post['mq5'] ?? 0);
        $lectura->dht22_temperatura = (float) ($post['temperatura'] ?? 0);
        $lectura->dht22_humedad     = (float) ($post['humedad'] ?? 0);
        $lectura->fecha_hora        = date('Y-m-d H:i:s');

        if (!$lectura->save()) {
            Yii::$app->response->statusCode = 500;
            return ['ok' => false, 'error' => $lectura->errors];
        }

        $this->generarAlertaSiNecesario(
            (int)$post['id_dispositivo'],
            (float)$post['mq135'],
            (float)($post['mq5'] ?? 0)
        );

        return ['ok' => true, 'id' => $lectura->id_lectura];
    }

    public function actionUltima(int $id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $lectura = LecturasSensores::find()
            ->where(['id_dispositivo' => $id])
            ->orderBy(['fecha_hora' => SORT_DESC])
            ->one();

        if (!$lectura) {
            return ['ok' => false, 'error' => 'Sin lecturas'];
        }

        return [
            'ok'          => true,
            'mq135'       => (float) $lectura->mq135_valor,
            'mq5'         => (float) $lectura->mq5_valor,
            'temperatura' => (float) $lectura->dht22_temperatura,
            'humedad'     => (float) $lectura->dht22_humedad,
            'fecha_hora'  => $lectura->fecha_hora,
        ];
    }

    public function actionUmbrales()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $amarillo = UmbralesConfiguracion::find()->where(['parametro' => 'mq135_amarillo'])->one();
        $rojo     = UmbralesConfiguracion::find()->where(['parametro' => 'mq135_rojo'])->one();
        $fuga     = UmbralesConfiguracion::find()->where(['parametro' => 'mq5_fuga'])->one();

        if (!$amarillo || !$rojo || !$fuga) {
            Yii::$app->response->statusCode = 404;
            return ['ok' => false, 'error' => 'Umbrales no encontrados en la base de datos'];
        }

        return [
            'ok'             => true,
            'mq135_amarillo' => (float) $amarillo->valor_limite,
            'mq135_rojo'     => (float) $rojo->valor_limite,
            'mq5_fuga'       => (float) $fuga->valor_limite,
        ];
    }

    private function generarAlertaSiNecesario(int $idDispositivo, float $ppm, float $mq5 = 0.0)
    {
        $alertasPendientes = [];

        // — Evaluación MQ135 (calidad del aire) —
        if ($ppm >= 1000) {
            $alertasPendientes[] = [
                'nivel'   => 'muy alto',
                'mensaje' => "Concentración crítica de {$ppm} ppm detectada. Riesgo para la salud.",
            ];
        } elseif ($ppm >= 700) {
            $alertasPendientes[] = [
                'nivel'   => 'alto',
                'mensaje' => "Nivel elevado de {$ppm} ppm. Se recomienda ventilación.",
            ];
        }

        // — Evaluación MQ5 (gas combustible) —
        if ($mq5 > 300) {
            $alertasPendientes[] = [
                'nivel'   => 'CRITICO',
                'mensaje' => "Gas combustible MQ5: {$mq5} ppm - Riesgo de explosión",
            ];
        } elseif ($mq5 > 120) {
            $alertasPendientes[] = [
                'nivel'   => 'ADVERTENCIA',
                'mensaje' => "Gas combustible MQ5: {$mq5} ppm - Nivel elevado",
            ];
        }

        // — Insertar una fila por cada alerta generada —
        foreach ($alertasPendientes as $item) {
            $alerta                    = new AlertasHistorial();
            $alerta->id_dispositivo    = $idDispositivo;
            $alerta->nivel_peligro     = $item['nivel'];
            $alerta->mensaje_alerta    = $item['mensaje'];
            $alerta->fecha_hora        = date('Y-m-d H:i:s');
            $alerta->leida_por_usuario = 0;
            $alerta->save();
        }
    }
}