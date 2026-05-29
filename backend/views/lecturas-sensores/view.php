<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\LecturasSensores $model */

$this->title = $model->id_lectura;
$this->params['breadcrumbs'][] = ['label' => 'Lecturas Sensores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lecturas-sensores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_lectura' => $model->id_lectura], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_lectura' => $model->id_lectura], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_lectura',
            'id_dispositivo',
            'mq135_valor',
            'dht22_temperatura',
            'dht22_humedad',
            'fecha_hora',
        ],
    ]) ?>

</div>
