<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\EstadoActuadores $model */

$this->title = $model->id_dispositivo;
$this->params['breadcrumbs'][] = ['label' => 'Estado Actuadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="estado-actuadores-view">

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
            'color_led',
            'buzzer_activo',
            'modo_operacion',
            'ultima_actualizacion',
        ],
    ]) ?>

</div>
