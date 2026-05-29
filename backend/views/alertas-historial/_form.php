<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\AlertasHistorial $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="alertas-historial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_dispositivo')->textInput() ?>

    <?= $form->field($model, 'nivel_peligro')->dropDownList([ 'ADVERTENCIA' => 'ADVERTENCIA', 'CRITICO' => 'CRITICO', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'mensaje_alerta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_hora')->textInput() ?>

    <?= $form->field($model, 'leida_por_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
