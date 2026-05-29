<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "umbrales_configuracion".
 *
 * @property int $id_configuracion
 * @property string|null $parametro
 * @property float|null $valor_limite
 * @property string|null $descripcion
 */
class UmbralesConfiguracion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'umbrales_configuracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parametro', 'valor_limite', 'descripcion'], 'default', 'value' => null],
            [['valor_limite'], 'number'],
            [['parametro'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_configuracion' => 'Id Configuracion',
            'parametro' => 'Parametro',
            'valor_limite' => 'Valor Limite',
            'descripcion' => 'Descripcion',
        ];
    }

}
