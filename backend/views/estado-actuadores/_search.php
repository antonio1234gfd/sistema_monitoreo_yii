<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\EstadoActuadoresSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estado-actuadores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_dispositivo') ?>

    <?= $form->field($model, 'color_led') ?>

    <?= $form->field($model, 'buzzer_activo') ?>

    <?= $form->field($model, 'modo_operacion') ?>

    <?= $form->field($model, 'ultima_actualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
