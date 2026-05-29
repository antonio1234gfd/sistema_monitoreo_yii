<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EstadoActuadores;

/**
 * EstadoActuadoresSearch represents the model behind the search form of `common\models\EstadoActuadores`.
 */
class EstadoActuadoresSearch extends EstadoActuadores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dispositivo', 'buzzer_activo'], 'integer'],
            [['color_led', 'modo_operacion', 'ultima_actualizacion'], 'safe'],
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
        $query = EstadoActuadores::find();

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
            'buzzer_activo' => $this->buzzer_activo,
            'ultima_actualizacion' => $this->ultima_actualizacion,
        ]);

        $query->andFilterWhere(['like', 'color_led', $this->color_led])
            ->andFilterWhere(['like', 'modo_operacion', $this->modo_operacion]);

        return $dataProvider;
    }
}
