<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">

  <!-- Encabezado -->
  <div class="mb-4">
    <h1 class="h4 fw-semibold mb-1"><?= Html::encode($this->title) ?></h1>
    <p class="text-muted small mb-0">
      Consultas, reportes de fallas o soporte técnico del sistema de monitoreo.
    </p>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius: 16px; max-width: 580px;">
    <div class="card-body p-4">

      <!-- Aviso informativo -->
      <div class="d-flex align-items-center gap-2 rounded-3 mb-4 px-3 py-2"
           style="background: #EAF3DE; border: 0.5px solid #97C459; font-size: 13px; color: #27500A;">
        <i class="bi bi-info-circle flex-shrink-0"></i>
        Nuestro equipo responde en un plazo de 24–48 horas hábiles.
      </div>

      <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'fieldConfig' => [
          'labelOptions' => ['class' => 'form-label small text-muted mb-1'],
          'errorOptions' => ['class' => 'invalid-feedback'],
        ],
      ]); ?>

        <!-- Nombre y correo en dos columnas -->
        <div class="row g-3 mb-1">
          <div class="col-sm-6">
            <?= $form->field($model, 'name', [
              'inputOptions' => ['autofocus' => true, 'placeholder' => 'Tu nombre completo']
            ])->label('<i class="bi bi-person me-1"></i>Nombre') ?>
          </div>
          <div class="col-sm-6">
            <?= $form->field($model, 'email', [
              'inputOptions' => ['placeholder' => 'correo@ejemplo.com']
            ])->label('<i class="bi bi-envelope me-1"></i>Correo electrónico') ?>
          </div>
        </div>

        <?= $form->field($model, 'subject', [
          'inputOptions' => ['placeholder' => '¿Sobre qué trata tu mensaje?']
        ])->label('<i class="bi bi-tag me-1"></i>Asunto') ?>

        <?= $form->field($model, 'body', [
          'inputOptions' => ['placeholder' => 'Describe tu consulta con el mayor detalle posible...']
        ])->textarea(['rows' => 5])
          ->label('<i class="bi bi-chat-text me-1"></i>Mensaje') ?>

        <!-- CAPTCHA -->
        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
          'template' => '
            <div class="d-flex align-items-center gap-3">
              <div style="border-radius:10px; overflow:hidden; flex-shrink:0;">{image}</div>
              <div class="flex-grow-1">{input}</div>
            </div>',
          'imageOptions' => ['style' => 'border-radius: 10px;'],
          'options'      => ['placeholder' => 'Escribe el código de la imagen'],
        ])->label('<i class="bi bi-shield-check me-1"></i>Verificación') ?>

        <!-- Botón enviar -->
        <div class="mt-3">
          <?= Html::submitButton(
            '<i class="bi bi-send me-2"></i>Enviar mensaje',
            ['class' => 'btn btn-success', 'name' => 'contact-button']
          ) ?>
        </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>

</div>