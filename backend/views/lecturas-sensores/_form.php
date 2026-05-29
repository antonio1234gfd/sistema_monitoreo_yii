<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LecturasSensores $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lecturas-sensores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_dispositivo')->textInput() ?>

    <?= $form->field($model, 'mq135_valor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dht22_temperatura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dht22_humedad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_hora')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
