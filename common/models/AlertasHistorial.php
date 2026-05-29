<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "alertas_historial".
 *
 * @property int $id_alerta
 * @property int|null $id_dispositivo
 * @property string|null $nivel_peligro
 * @property string|null $mensaje_alerta
 * @property string|null $fecha_hora
 * @property int|null $leida_por_usuario
 *
 * @property Dispositivos $dispositivo
 */
class AlertasHistorial extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const NIVEL_PELIGRO_ADVERTENCIA = 'ADVERTENCIA';
    const NIVEL_PELIGRO_CRITICO = 'CRITICO';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alertas_historial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dispositivo', 'nivel_peligro', 'mensaje_alerta'], 'default', 'value' => null],
            [['leida_por_usuario'], 'default', 'value' => 0],
            [['id_dispositivo', 'leida_por_usuario'], 'integer'],
            [['nivel_peligro', 'mensaje_alerta'], 'string'],
            [['fecha_hora'], 'safe'],
            ['nivel_peligro', 'in', 'range' => array_keys(self::optsNivelPeligro())],
            [['id_dispositivo'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::class, 'targetAttribute' => ['id_dispositivo' => 'id_dispositivo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alerta' => 'Id Alerta',
            'id_dispositivo' => 'Id Dispositivo',
            'nivel_peligro' => 'Nivel Peligro',
            'mensaje_alerta' => 'Mensaje Alerta',
            'fecha_hora' => 'Fecha Hora',
            'leida_por_usuario' => 'Leida Por Usuario',
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


    /**
     * column nivel_peligro ENUM value labels
     * @return string[]
     */
    public static function optsNivelPeligro()
    {
        return [
            self::NIVEL_PELIGRO_ADVERTENCIA => 'ADVERTENCIA',
            self::NIVEL_PELIGRO_CRITICO => 'CRITICO',
        ];
    }

    /**
     * @return string
     */
    public function displayNivelPeligro()
    {
        return self::optsNivelPeligro()[$this->nivel_peligro];
    }

    /**
     * @return bool
     */
    public function isNivelPeligroAdvertencia()
    {
        return $this->nivel_peligro === self::NIVEL_PELIGRO_ADVERTENCIA;
    }

    public function setNivelPeligroToAdvertencia()
    {
        $this->nivel_peligro = self::NIVEL_PELIGRO_ADVERTENCIA;
    }

    /**
     * @return bool
     */
    public function isNivelPeligroCritico()
    {
        return $this->nivel_peligro === self::NIVEL_PELIGRO_CRITICO;
    }

    public function setNivelPeligroToCritico()
    {
        $this->nivel_peligro = self::NIVEL_PELIGRO_CRITICO;
    }
}
