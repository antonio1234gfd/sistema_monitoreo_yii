<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\LecturasSensoresSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lecturas-sensores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_lectura') ?>

    <?= $form->field($model, 'id_dispositivo') ?>

    <?= $form->field($model, 'mq135_valor') ?>

    <?= $form->field($model, 'dht22_temperatura') ?>

    <?= $form->field($model, 'dht22_humedad') ?>

    <?php // echo $form->field($model, 'fecha_hora') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
