<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User
{
    public $rolNombre;
    public $estadoNombre;
    public $tipoUsuarioNombre;
    public $perfilNombre;

    public function rules()
    {
        return [
            [['id', 'rol_id', 'estado_id', 'tipo_usuario_id'], 'integer'],
            [['username', 'email', 'created_at',
              'rolNombre', 'estadoNombre', 'tipoUsuarioNombre', 'perfilNombre'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()->alias('u');

        $query->joinWith(['rol r'])
              ->joinWith(['estado e'])
              ->joinWith(['tipoUsuario t'])
              ->joinWith(['perfil p']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [

                'id',
                'username',
                'email',

                'rolNombre' => [
                    'asc' => ['r.rol_nombre' => SORT_ASC],
                    'desc' => ['r.rol_nombre' => SORT_DESC],
                ],

                'estadoNombre' => [
                    'asc' => ['e.estado_nombre' => SORT_ASC],
                    'desc' => ['e.estado_nombre' => SORT_DESC],
                ],

                'tipoUsuarioNombre' => [
                    'asc' => ['t.tipo_usuario_nombre' => SORT_ASC],
                    'desc' => ['t.tipo_usuario_nombre' => SORT_DESC],
                ],

                'perfilNombre' => [
                    'asc' => ['p.nombre' => SORT_ASC],
                    'desc' => ['p.nombre' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // filtros principales
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.rol_id' => $this->rol_id,
            'u.estado_id' => $this->estado_id,
            'u.tipo_usuario_id' => $this->tipo_usuario_id,
        ]);

        $query->andFilterWhere(['like', 'u.username', $this->username])
              ->andFilterWhere(['like', 'u.email', $this->email]);

        // filtros por relaciones
        $query->andFilterWhere(['like', 'r.rol_nombre', $this->rolNombre])
              ->andFilterWhere(['like', 'e.estado_nombre', $this->estadoNombre])
              ->andFilterWhere(['like', 't.tipo_usuario_nombre', $this->tipoUsuarioNombre])
              ->andFilterWhere(['like', 'p.nombre', $this->perfilNombre]);

        return $dataProvider;
    }
}