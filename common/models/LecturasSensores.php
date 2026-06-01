<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lecturas_sensores".
 *
 * @property int $id_lectura
 * @property int|null $id_dispositivo
 * @property float|null $mq135_valor
 * @property float|null $mq5_valor
 * @property float|null $dht22_temperatura
 * @property float|null $dht22_humedad
 * @property string|null $fecha_hora
 *
 * @property Dispositivos $dispositivo
 */
class LecturasSensores extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecturas_sensores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dispositivo', 'mq135_valor', 'mq5_valor', 'dht22_temperatura', 'dht22_humedad'], 'default', 'value' => null],
            [['id_dispositivo'], 'integer'],
            [['mq135_valor', 'mq5_valor', 'dht22_temperatura', 'dht22_humedad'], 'number'],
            [['fecha_hora'], 'safe'],
            [['id_dispositivo'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::class, 'targetAttribute' => ['id_dispositivo' => 'id_dispositivo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_lectura' => 'Id Lectura',
            'id_dispositivo' => 'Id Dispositivo',
            'mq135_valor' => 'Mq135 Valor',
            'mq5_valor' => 'MQ5 (ppm)',
            'dht22_temperatura' => 'Dht22 Temperatura',
            'dht22_humedad' => 'Dht22 Humedad',
            'fecha_hora' => 'Fecha Hora',
        ];
    }

    /**
     * Gets query for [[Dispositivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDispositivo()
    {
        return $this->hasOne(Dispositivos::class, ['id_dispositivo' => 'id_dispositivo']);
    }

}
