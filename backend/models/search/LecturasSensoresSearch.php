<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LecturasSensores;

/**
 * LecturasSensoresSearch represents the model behind the search form of `common\models\LecturasSensores`.
 */
class LecturasSensoresSearch extends LecturasSensores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lectura', 'id_dispositivo'], 'integer'],
            [['mq135_valor', 'dht22_temperatura', 'dht22_humedad'], 'number'],
            [['fecha_hora'], 'safe'],
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
        $query = LecturasSensores::find();

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
            'id_lectura' => $this->id_lectura,
            'id_dispositivo' => $this->id_dispositivo,
            'mq135_valor' => $this->mq135_valor,
            'dht22_temperatura' => $this->dht22_temperatura,
            'dht22_humedad' => $this->dht22_humedad,
            'fecha_hora' => $this->fecha_hora,
        ]);

        return $dataProvider;
    }
}
