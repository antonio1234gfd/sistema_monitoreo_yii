<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Dispositivos $model */

$this->title = 'Update Dispositivos: ' . $model->id_dispositivo;
$this->params['breadcrumbs'][] = ['label' => 'Dispositivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_dispositivo, 'url' => ['view', 'id_dispositivo' => $model->id_dispositivo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dispositivos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
