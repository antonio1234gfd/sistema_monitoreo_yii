<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EstadoActuadores $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estado-actuadores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_dispositivo')->textInput() ?>

    <?= $form->field($model, 'color_led')->dropDownList([ 'VERDE' => 'VERDE', 'AMARILLO' => 'AMARILLO', 'ROJO' => 'ROJO', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'buzzer_activo')->textInput() ?>

    <?= $form->field($model, 'modo_operacion')->dropDownList([ 'AUTOMATICO' => 'AUTOMATICO', 'MANUAL' => 'MANUAL', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ultima_actualizacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
