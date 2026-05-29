<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Dispositivos $model */

$this->title = $model->id_dispositivo;
$this->params['breadcrumbs'][] = ['label' => 'Dispositivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dispositivos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_dispositivo' => $model->id_dispositivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_dispositivo' => $model->id_dispositivo], [
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
            'id_dispositivo',
            'user_id',
            'nombre',
            'ubicacion',
            'estado_red',
            'ultima_conexion',
        ],
    ]) ?>

</div>
