<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UmbralesConfiguracion $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="umbrales-configuracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parametro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor_limite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
