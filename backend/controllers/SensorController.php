<?php
/**
 * ARCHIVO: backend/controllers/SensorController.php
 *
 * Endpoint que recibe los datos del ESP32 por HTTP POST
 * y los guarda en la BD llamando al stored procedure.
 *
 * URL: http://localhost/sistema_mon/cursoyii2026B/advanced/backend/web/sensor/recibir
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class SensorController extends Controller
{
    // Desactivar CSRF para que el ESP32 pueda hacer POST sin token
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'recibir' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Recibe los datos del ESP32 y los guarda en la BD
     * llamando al stored procedure RegistrarLecturaESP32
     *
     * Parámetros POST esperados:
     *   - id_dispositivo (int)
     *   - mq135          (float) ppm
     *   - temperatura    (float) °C
     *   - humedad        (float) %
     */
    public function actionRecibir()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        // Leer parámetros del POST
        $idDispositivo = (int)   $request->post('id_dispositivo');
        $mq135         = (float) $request->post('mq135');
        $temperatura   = (float) $request->post('temperatura');
        $humedad       = (float) $request->post('humedad');
        
        // Capturar mq5 de forma robusta (soportando variantes de nombre)
        $post          = $request->post();
        $mq5           = (float) ($post['mq5'] ?? $post['MQ5'] ?? $post['mq_5'] ?? 0);

        // Validación básica
        if (!$idDispositivo || !$mq135) {
            Yii::$app->response->statusCode = 400;
            return [
                'status'  => 'error',
                'mensaje' => 'Parámetros incompletos. Se requiere id_dispositivo y mq135.',
            ];
        }

        try {
            // Llamar al stored procedure con el nuevo parámetro mq5
            // El trigger AlertaCalidadAire_MQ135 se ejecuta automáticamente
            Yii::$app->db->createCommand('CALL RegistrarLecturaESP32(:id, :mq135, :temp, :hum, :mq5)')
                ->bindValue(':id',    $idDispositivo)
                ->bindValue(':mq135', $mq135)
                ->bindValue(':temp',  $temperatura)
                ->bindValue(':hum',   $humedad)
                ->bindValue(':mq5',   $mq5)
                ->execute();

            Yii::info(
                "Lectura recibida — Dispositivo: $idDispositivo | "
                . "MQ135: {$mq135} ppm | Temp: {$temperatura} C | Hum: {$humedad}% | MQ5: {$mq5}",
                'sensor'
            );

            return [
                'status'  => 'ok',
                'mensaje' => 'Lectura registrada correctamente.',
                'datos'   => [
                    'id_dispositivo' => $idDispositivo,
                    'mq135'          => $mq135,
                    'mq5'            => $mq5,
                    'temperatura'    => $temperatura,
                    'humedad'        => $humedad,
                ],
            ];

        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error('Error al guardar lectura ESP32: ' . $e->getMessage(), 'sensor');

            return [
                'status'  => 'error',
                'mensaje' => 'Error interno al guardar la lectura.',
            ];
        }
    }
}