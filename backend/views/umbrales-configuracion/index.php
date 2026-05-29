<?php

use common\models\UmbralesConfiguracion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\UmbralesConfiguracionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Umbrales Configuracions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="umbrales-configuracion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Umbrales Configuracion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_configuracion',
            'parametro',
            'valor_limite',
            'descripcion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UmbralesConfiguracion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_configuracion' => $model->id_configuracion]);
                 }
            ],
        ],
    ]); ?>


</div>
