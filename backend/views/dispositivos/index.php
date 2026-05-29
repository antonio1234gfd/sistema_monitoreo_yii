<?php

use common\models\Dispositivos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\DispositivosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dispositivos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dispositivos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dispositivos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_dispositivo',
            'user_id',
            'nombre',
            'ubicacion',
            'estado_red',
            //'ultima_conexion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Dispositivos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_dispositivo' => $model->id_dispositivo]);
                 }
            ],
        ],
    ]); ?>


</div>
