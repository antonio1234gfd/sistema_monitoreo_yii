<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AlertasHistorial $model */

$this->title = 'Update Alertas Historial: ' . $model->id_alerta;
$this->params['breadcrumbs'][] = ['label' => 'Alertas Historials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_alerta, 'url' => ['view', 'id_alerta' => $model->id_alerta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alertas-historial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
