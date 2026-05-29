<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Genero; // Asegúrate de tener este import para la relación

/**
 * Modelo para la tabla "perfil".
 */
class Perfil extends ActiveRecord
{
    public static function tableName()
    {
        return 'perfil';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['genero_id'], 'required'],
            [['user_id', 'genero_id'], 'integer'],
            [['genero_id'], 'in', 'range' => array_keys($this->getGeneroLista())],
            [['nombre', 'apellido'], 'string', 'max' => 255],
            [['fecha_nacimiento', 'created_at', 'updated_at'], 'safe'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->fecha_nacimiento != null) {
            $nuevo_formato_fecha = date('Y-m-d', strtotime($this->fecha_nacimiento));
            $this->fecha_nacimiento = $nuevo_formato_fecha;
        }
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero_id' => 'Género',
            'userLink' => Yii::t('app', 'Usuario'),
            'perfilIdLink' => Yii::t('app', 'Perfil'),
        ];
    }

    /* ===================== RELACIONES ===================== */

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getGenero()
    {
        return $this->hasOne(Genero::class, ['id' => 'genero_id']);
    }

    public static function getGeneroLista()
    {
        $dropciones = Genero::find()->asArray()->all();
        return ArrayHelper::map($dropciones, 'id', 'genero_nombre');
    }

    /* ===================== MÉTODOS DE ENLACE ===================== */

    /**
     * Crea un enlace al usuario (Basado en imagen_910cb6.png)
     */
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id' => $this->user_id]);
        $options = []; 
        
        // El libro pide usar $this->user->username. 
        // Agregamos la validación para evitar errores si el usuario no existe.
        return $this->user 
            ? Html::a($this->user->username, $url, $options) 
            : '- no vinculado -';
    }

    /**
     * Crea un enlace rápido usando el ID del perfil (Basado en imagen_909b9d.png)
     */
    public function getPerfilIdLink()
    {
        $url = Url::to(['perfil/update', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

    /**
     * Obtiene el nombre del género de forma segura
     */
    public function getGeneroNombre()
    {
        return $this->genero ? $this->genero->genero_nombre : '- no definido -';
    }
}