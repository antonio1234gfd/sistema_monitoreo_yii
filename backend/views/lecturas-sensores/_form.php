<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LecturasSensores $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="lecturas-sensores-form">
  <div class="card border-0 shadow-sm p-4" style="border-radius:16px; max-width:560px;">

    <?php $form = ActiveForm::begin([
      'fieldConfig' => [
        'labelOptions' => ['class' => 'form-label small text-muted mb-1'],
      ],
    ]); ?>

    <div class="row g-3">

      <div class="col-12">
        <?= $form->field($model, 'id_dispositivo', [
          'inputOptions' => ['placeholder' => 'Ej: 1']
        ])->textInput()->label('<i class="bi bi-cpu me-1"></i>ID Dispositivo') ?>
      </div>

      <div class="col-sm-6">
        <?= $form->field($model, 'mq135_valor', [
          'inputOptions' => ['placeholder' => 'ppm', 'step' => '0.01', 'type' => 'number']
        ])->textInput()->label('<i class="bi bi-wind me-1"></i>MQ135 — Calidad del aire (ppm)') ?>
      </div>

      <div class="col-sm-6">
        <?= $form->field($model, 'mq5_valor', [
          'inputOptions' => ['placeholder' => 'ppm', 'step' => '0.01', 'type' => 'number']
        ])->textInput()->label('<i class="bi bi-fire me-1"></i>MQ5 — Gas LP / metano (ppm)') ?>
      </div>

      <div class="col-sm-6">
        <?= $form->field($model, 'dht22_temperatura', [
          'inputOptions' => ['placeholder' => '°C', 'step' => '0.1', 'type' => 'number']
        ])->textInput()->label('<i class="bi bi-thermometer-half me-1"></i>Temperatura (°C)') ?>
      </div>

      <div class="col-sm-6">
        <?= $form->field($model, 'dht22_humedad', [
          'inputOptions' => ['placeholder' => '%', 'step' => '0.1', 'type' => 'number']
        ])->textInput()->label('<i class="bi bi-droplet me-1"></i>Humedad (%)') ?>
      </div>

      <div class="col-12">
        <?= $form->field($model, 'fecha_hora', [
          'inputOptions' => ['type' => 'datetime-local']
        ])->textInput()->label('<i class="bi bi-clock me-1"></i>Fecha y hora') ?>
      </div>

    </div>

    <div class="mt-4 d-flex gap-2">
      <?= Html::submitButton(
        '<i class="bi bi-save me-1"></i>Guardar lectura',
        ['class' => 'btn btn-success']
      ) ?>
      <?= Html::a(
        '<i class="bi bi-arrow-left me-1"></i>Cancelar',
        ['index'],
        ['class' => 'btn btn-outline-secondary']
      ) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</div>