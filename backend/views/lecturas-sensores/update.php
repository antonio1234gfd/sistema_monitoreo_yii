<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LecturasSensores $model */

$this->title = 'Update Lecturas Sensores: ' . $model->id_lectura;
$this->params['breadcrumbs'][] = ['label' => 'Lecturas Sensores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_lectura, 'url' => ['view', 'id_lectura' => $model->id_lectura]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lecturas-sensores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
