<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UmbralesConfiguracion;

/**
 * UmbralesConfiguracionSearch represents the model behind the search form of `common\models\UmbralesConfiguracion`.
 */
class UmbralesConfiguracionSearch extends UmbralesConfiguracion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_configuracion'], 'integer'],
            [['parametro', 'descripcion'], 'safe'],
            [['valor_limite'], 'number'],
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
        $query = UmbralesConfiguracion::find();

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
            'id_configuracion' => $this->id_configuracion,
            'valor_limite' => $this->valor_limite,
        ]);

        $query->andFilterWhere(['like', 'parametro', $this->parametro])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
