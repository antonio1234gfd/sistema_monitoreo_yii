<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dispositivos".
 *
 * @property int $id_dispositivo
 * @property int $user_id
 * @property string $nombre
 * @property string|null $ubicacion
 * @property int|null $estado_red
 * @property string|null $ultima_conexion
 *
 * @property AlertasHistorial[] $alertasHistorials
 * @property EstadoActuadores $estadoActuadores
 * @property LecturasSensores[] $lecturasSensores
 * @property Users $user
 */
class Dispositivos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dispositivos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ubicacion'], 'default', 'value' => null],
            [['estado_red'], 'default', 'value' => 1],
            [['user_id', 'nombre'], 'required'],
            [['user_id', 'estado_red'], 'integer'],
            [['ultima_conexion'], 'safe'],
            [['nombre'], 'string', 'max' => 50],
            [['ubicacion'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dispositivo' => 'Id Dispositivo',
            'user_id' => 'User ID',
            'nombre' => 'Nombre',
            'ubicacion' => 'Ubicacion',
            'estado_red' => 'Estado Red',
            'ultima_conexion' => 'Ultima Conexion',
        ];
    }

    /**
     * Gets query for [[AlertasHistorials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertasHistorials()
    {
        return $this->hasMany(AlertasHistorial::class, ['id_dispositivo' => 'id_dispositivo']);
    }

    /**
     * Gets query for [[EstadoActuadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoActuadores()
    {
        return $this->hasOne(EstadoActuadores::class, ['id_dispositivo' => 'id_dispositivo']);
    }

    /**
     * Gets query for [[LecturasSensores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLecturasSensores()
    {
        return $this->hasMany(LecturasSensores::class, ['id_dispositivo' => 'id_dispositivo']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
