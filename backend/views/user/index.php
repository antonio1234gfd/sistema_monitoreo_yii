<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#searchBox">
            Mostrar / Ocultar Búsqueda
        </a>
    </p>

    <div class="collapse" id="searchBox">
        <div class="card card-body">
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
    </div>

    <div class="mt-4">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [

                ['class' => 'yii\grid\SerialColumn'],

                'id',

                [
                    'attribute' => 'username',
                    'label' => 'User',
                    'value' => fn($model) => $model->userLink,
                    'format' => 'raw',
                ],

                [
                    'attribute' => 'perfil',
                    'label' => 'Perfil',
                    'value' => fn($model) => $model->perfilLink,
                    'format' => 'raw',
                ],

                'email:email',

                [
                    'attribute' => 'rol_id',
                    'label' => 'Rol',
                    'value' => fn($model) => $model->rolNombre,
                ],

                [
                    'attribute' => 'estado_id',
                    'label' => 'Estado',
                    'value' => fn($model) => $model->estadoNombre,
                ],

                [
                    'attribute' => 'tipo_usuario_id',
                    'label' => 'Tipo Usuario',
                    'value' => fn($model) => $model->tipoUsuarioNombre,
                ],

                'created_at:datetime',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>

</div>