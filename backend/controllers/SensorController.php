<?php
/**
 * ARCHIVO: backend/controllers/SensorController.php
 *
 * Endpoint que recibe los datos del ESP32 por HTTP POST
 * y los guarda en la BD llamando al stored procedure.
 *
 * URL: http://192.168.0.55/sistema_mon/cursoyii2026B/advanced/backend/web/index.php?r=sensor/recibir
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
     *   - mq135          (float) delta ppm MQ135
     *   - mq5            (float) delta ppm MQ5
     *   - temperatura    (float) °C
     *   - humedad        (float) %
     *   - color_led      (string) VERDE | AMARILLO | ROJO
     *   - buzzer_activo  (int)   0 | 1
     *   - modo_operacion (string) normal | advertencia | critico
     */
    public function actionRecibir()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        // Leer parámetros del POST
        $idDispositivo = (int)   $request->post('id_dispositivo');
        $mq135         = (float) $request->post('mq135');
        $mq5           = (float) $request->post('mq5',            0);
        $temperatura   = (float) $request->post('temperatura',    0);
        $humedad       = (float) $request->post('humedad',        0);
        $colorLed      =         $request->post('color_led',      'VERDE');
        $buzzer        = (int)   $request->post('buzzer_activo',  0);
        $modo          =         $request->post('modo_operacion', 'normal');

        // Validación básica
        if (!$idDispositivo || !$mq135) {
            Yii::$app->response->statusCode = 400;
            return [
                'status'  => 'error',
                'mensaje' => 'Parámetros incompletos. Se requiere id_dispositivo y mq135.',
            ];
        }

        try {
            // Llamar al stored procedure
            // El trigger AlertaCalidadAire_MQ135 se ejecuta automáticamente
            Yii::$app->db->createCommand(
                'CALL RegistrarLecturaESP32(:id, :mq135, :mq5, :temp, :hum, :led, :buzzer, :modo)'
            )
            ->bindValue(':id',     $idDispositivo)
            ->bindValue(':mq135',  $mq135)
            ->bindValue(':mq5',    $mq5)
            ->bindValue(':temp',   $temperatura)
            ->bindValue(':hum',    $humedad)
            ->bindValue(':led',    $colorLed)
            ->bindValue(':buzzer', $buzzer)
            ->bindValue(':modo',   $modo)
            ->execute();

            Yii::info(
                "Lectura recibida — Dispositivo: $idDispositivo | "
                . "MQ135: $mq135 | MQ5: $mq5 | "
                . "Temp: $temperatura°C | Hum: $humedad% | "
                . "LED: $colorLed | Buzzer: $buzzer | Modo: $modo",
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
                    'color_led'      => $colorLed,
                    'buzzer_activo'  => $buzzer,
                    'modo_operacion' => $modo,
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