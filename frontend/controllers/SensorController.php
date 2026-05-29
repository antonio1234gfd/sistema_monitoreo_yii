<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LecturasSensores;
use common\models\AlertasHistorial;

class SensorController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['recibir', 'ultima'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'recibir' => ['POST'],
                    'ultima'  => ['GET'],
                ],
            ],
        ];
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
        $lectura->id_dispositivo = (int) $post['id_dispositivo'];
        $lectura->mq135          = (float) $post['mq135'];
        $lectura->temperatura    = (float) ($post['temperatura'] ?? 0);
        $lectura->humedad        = (float) ($post['humedad'] ?? 0);
        $lectura->fecha_hora     = date('Y-m-d H:i:s');

        if (!$lectura->save()) {
            Yii::$app->response->statusCode = 500;
            return ['ok' => false, 'error' => $lectura->errors];
        }

        $this->generarAlertaSiNecesario((int)$post['id_dispositivo'], (float)$post['mq135']);

        return ['ok' => true, 'id' => $lectura->id];
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
            'mq135'       => $lectura->mq135,
            'temperatura' => $lectura->temperatura,
            'humedad'     => $lectura->humedad,
            'fecha_hora'  => $lectura->fecha_hora,
        ];
    }

    private function generarAlertaSiNecesario(int $idDispositivo, float $ppm)
    {
        if ($ppm >= 1000) {
            $nivel   = 'muy alto';
            $mensaje = "Concentración crítica de {$ppm} ppm detectada. Riesgo para la salud.";
        } elseif ($ppm >= 700) {
            $nivel   = 'alto';
            $mensaje = "Nivel elevado de {$ppm} ppm. Se recomienda ventilación.";
        } else {
            return;
        }

        $alerta                    = new AlertasHistorial();
        $alerta->id_dispositivo    = $idDispositivo;
        $alerta->nivel_peligro     = $nivel;
        $alerta->mensaje_alerta    = $mensaje;
        $alerta->fecha_hora        = date('Y-m-d H:i:s');
        $alerta->leida_por_usuario = 0;
        $alerta->save();
    }
}