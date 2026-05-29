<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AlertasHistorial;

/**
 * AlertasHistorialSearch represents the model behind the search form of `common\models\AlertasHistorial`.
 */
class AlertasHistorialSearch extends AlertasHistorial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alerta', 'id_dispositivo', 'leida_por_usuario'], 'integer'],
            [['nivel_peligro', 'mensaje_alerta', 'fecha_hora'], 'safe'],
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
        $query = AlertasHistorial::find();

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
            'id_alerta' => $this->id_alerta,
            'id_dispositivo' => $this->id_dispositivo,
            'fecha_hora' => $this->fecha_hora,
            'leida_por_usuario' => $this->leida_por_usuario,
        ]);

        $query->andFilterWhere(['like', 'nivel_peligro', $this->nivel_peligro])
            ->andFilterWhere(['like', 'mensaje_alerta', $this->mensaje_alerta]);

        return $dataProvider;
    }
}
