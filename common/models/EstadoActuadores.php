<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estado_actuadores".
 *
 * @property int $id_dispositivo
 * @property string|null $color_led
 * @property int|null $buzzer_activo
 * @property string|null $modo_operacion
 * @property string|null $ultima_actualizacion
 *
 * @property Dispositivos $dispositivo
 */
class EstadoActuadores extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const COLOR_LED_VERDE = 'VERDE';
    const COLOR_LED_AMARILLO = 'AMARILLO';
    const COLOR_LED_ROJO = 'ROJO';
    const MODO_OPERACION_AUTOMATICO = 'AUTOMATICO';
    const MODO_OPERACION_MANUAL = 'MANUAL';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_actuadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_led'], 'default', 'value' => 'VERDE'],
            [['buzzer_activo'], 'default', 'value' => 0],
            [['modo_operacion'], 'default', 'value' => 'AUTOMATICO'],
            [['id_dispositivo'], 'required'],
            [['id_dispositivo', 'buzzer_activo'], 'integer'],
            [['color_led', 'modo_operacion'], 'string'],
            [['ultima_actualizacion'], 'safe'],
            ['color_led', 'in', 'range' => array_keys(self::optsColorLed())],
            ['modo_operacion', 'in', 'range' => array_keys(self::optsModoOperacion())],
            [['id_dispositivo'], 'unique'],
            [['id_dispositivo'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::class, 'targetAttribute' => ['id_dispositivo' => 'id_dispositivo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dispositivo' => 'Id Dispositivo',
            'color_led' => 'Color Led',
            'buzzer_activo' => 'Buzzer Activo',
            'modo_operacion' => 'Modo Operacion',
            'ultima_actualizacion' => 'Ultima Actualizacion',
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
     * column color_led ENUM value labels
     * @return string[]
     */
    public static function optsColorLed()
    {
        return [
            self::COLOR_LED_VERDE => 'VERDE',
            self::COLOR_LED_AMARILLO => 'AMARILLO',
            self::COLOR_LED_ROJO => 'ROJO',
        ];
    }

    /**
     * column modo_operacion ENUM value labels
     * @return string[]
     */
    public static function optsModoOperacion()
    {
        return [
            self::MODO_OPERACION_AUTOMATICO => 'AUTOMATICO',
            self::MODO_OPERACION_MANUAL => 'MANUAL',
        ];
    }

    /**
     * @return string
     */
    public function displayColorLed()
    {
        return self::optsColorLed()[$this->color_led];
    }

    /**
     * @return bool
     */
    public function isColorLedVerde()
    {
        return $this->color_led === self::COLOR_LED_VERDE;
    }

    public function setColorLedToVerde()
    {
        $this->color_led = self::COLOR_LED_VERDE;
    }

    /**
     * @return bool
     */
    public function isColorLedAmarillo()
    {
        return $this->color_led === self::COLOR_LED_AMARILLO;
    }

    public function setColorLedToAmarillo()
    {
        $this->color_led = self::COLOR_LED_AMARILLO;
    }

    /**
     * @return bool
     */
    public function isColorLedRojo()
    {
        return $this->color_led === self::COLOR_LED_ROJO;
    }

    public function setColorLedToRojo()
    {
        $this->color_led = self::COLOR_LED_ROJO;
    }

    /**
     * @return string
     */
    public function displayModoOperacion()
    {
        return self::optsModoOperacion()[$this->modo_operacion];
    }

    /**
     * @return bool
     */
    public function isModoOperacionAutomatico()
    {
        return $this->modo_operacion === self::MODO_OPERACION_AUTOMATICO;
    }

    public function setModoOperacionToAutomatico()
    {
        $this->modo_operacion = self::MODO_OPERACION_AUTOMATICO;
    }

    /**
     * @return bool
     */
    public function isModoOperacionManual()
    {
        return $this->modo_operacion === self::MODO_OPERACION_MANUAL;
    }

    public function setModoOperacionToManual()
    {
        $this->modo_operacion = self::MODO_OPERACION_MANUAL;
    }
}
