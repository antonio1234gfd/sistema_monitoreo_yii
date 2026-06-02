<?php
/**
 * ARCHIVO: frontend/controllers/DashboardController.php
 * Controlador del dashboard de monitoreo de calidad del aire.
 * Solo lectura — no permite edición ni eliminación.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Dispositivos;
use common\models\LecturasSensores;
use common\models\AlertasHistorial;
use common\models\EstadoActuadores;
use common\models\UmbralesConfiguracion;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
        ];
    }

    /**
     * Dashboard principal de monitoreo.
     * Muestra la última lectura del dispositivo del usuario autenticado,
     * el estado del LED/Buzzer, alertas enviadas y gráfica de lecturas recientes.
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        // Obtener el dispositivo del usuario actual
        $dispositivo = Dispositivos::find()
            ->where(['user_id' => $userId])
            ->one();

        $ultimaLectura    = null;
        $estadoActuador   = null;
        $alertas          = [];
        $graficaDatos     = [];

        if ($dispositivo) {
            $idDisp = $dispositivo->id_dispositivo;

            // Última lectura del sensor
            $ultimaLectura = LecturasSensores::find()
                ->where(['id_dispositivo' => $idDisp])
                ->orderBy(['fecha_hora' => SORT_DESC])
                ->one();

            // Estado actual del LED y Buzzer
            $estadoActuador = EstadoActuadores::find()
                ->where(['id_dispositivo' => $idDisp])
                ->one();

            // Últimas 5 alertas (solo lectura, solo saber si se enviaron)
            $alertas = AlertasHistorial::find()
                ->where(['id_dispositivo' => $idDisp])
                ->orderBy(['fecha_hora' => SORT_DESC])
                ->limit(5)
                ->all();

            // Últimas 20 lecturas para la gráfica
            $lecturas = LecturasSensores::find()
                ->where(['id_dispositivo' => $idDisp])
                ->orderBy(['fecha_hora' => SORT_ASC])
                ->limit(20)
                ->all();

            foreach ($lecturas as $l) {
                $graficaDatos[] = [
                    'hora'        => date('H:i', strtotime($l->fecha_hora)),
                    'mq135'       => (float) $l->mq135_valor,
                    'temperatura' => (float) $l->dht22_temperatura,
                    'humedad'     => (float) $l->dht22_humedad,
                ];
            }
        }

        // Cargar umbrales dinámicos desde la BD (con fallback si no existen)
        $umbrales = [
            'mq135_amarillo' => 3100.0,
            'mq135_rojo'     => 3500.0,
            'mq5_fuga'       => 1200.0,
        ];
        $filas = UmbralesConfiguracion::find()
            ->where(['parametro' => ['mq135_amarillo', 'mq135_rojo', 'mq5_fuga']])
            ->all();
        foreach ($filas as $row) {
            $umbrales[$row->parametro] = (float) $row->valor_limite;
        }

        return $this->render('index', [
            'dispositivo'   => $dispositivo,
            'ultimaLectura' => $ultimaLectura,
            'estadoActuador'=> $estadoActuador,
            'alertas'       => $alertas,
            'graficaDatos'  => $graficaDatos,
            'umbrales'      => $umbrales,
        ]);
    }
}