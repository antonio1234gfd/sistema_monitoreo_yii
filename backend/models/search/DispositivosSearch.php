<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dispositivos;

/**
 * DispositivosSearch represents the model behind the search form of `common\models\Dispositivos`.
 */
class DispositivosSearch extends Dispositivos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dispositivo', 'user_id', 'estado_red'], 'integer'],
            [['nombre', 'ubicacion', 'ultima_conexion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Dispositivos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_dispositivo' => $this->id_dispositivo,
            'user_id' => $this->user_id,
            'estado_red' => $this->estado_red,
            'ultima_conexion' => $this->ultima_conexion,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion]);

        return $dataProvider;
    }
}
