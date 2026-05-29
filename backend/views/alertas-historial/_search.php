<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\AlertasHistorialSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="alertas-historial-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_alerta') ?>

    <?= $form->field($model, 'id_dispositivo') ?>

    <?= $form->field($model, 'nivel_peligro') ?>

    <?= $form->field($model, 'mensaje_alerta') ?>

    <?= $form->field($model, 'fecha_hora') ?>

    <?php // echo $form->field($model, 'leida_por_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
