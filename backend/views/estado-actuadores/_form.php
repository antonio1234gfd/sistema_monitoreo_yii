<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EstadoActuadores $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estado-actuadores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_dispositivo')->textInput([
        'placeholder' => 'Ej: 1',
    ]) ?>

    <?= $form->field($model, 'color_led')->dropDownList([
        'VERDE'    => 'VERDE',
        'AMARILLO' => 'AMARILLO',
        'ROJO'     => 'ROJO',
    ], ['prompt' => '-- Selecciona color --']) ?>

    <?= $form->field($model, 'buzzer_activo')->dropDownList([
        0 => 'Inactivo',
        1 => 'Activo',
    ], ['prompt' => '-- Selecciona estado --']) ?>

    <?= $form->field($model, 'modo_operacion')->dropDownList([
        'AUTOMATICO' => 'AUTOMÁTICO',
        'MANUAL'     => 'MANUAL',
    ], ['prompt' => '-- Selecciona modo --']) ?>

    

    <div class="form-group mt-3">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Crear registro' : 'Guardar cambios',
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>