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

<div class="d-flex justify-content-center align-items-center"
     style="
     min-height:100vh;
     background: linear-gradient(
     135deg,
     #f8fafc 0%,
     #eef2f7 50%,
     #dbe4ee 100%);
     ">

  <div class="card border-0 shadow-lg"
       style="
       width:100%;
       max-width:600px;
       border-radius:24px;
       background:#ffffff;
       box-shadow:0 20px 60px rgba(0,0,0,.12);
       ">

    <div class="card-body p-5">

      <!-- Encabezado -->
      <div class="mb-4 text-center">
        <h1 class="fw-bold mb-1" style="color:#0f172a;">
          Contacto
        </h1>
        <p class="text-muted small mb-0">
          Consultas, reportes de fallas o soporte técnico del sistema de monitoreo.
        </p>
      </div>

      <!-- Info -->
      <div class="d-flex align-items-center gap-2 rounded-3 mb-4 px-3 py-2"
           style="
           background:#eef2f7;
           border:1px solid #d1d5db;
           font-size:13px;
           color:#475569;
           ">
        <i class="bi bi-info-circle flex-shrink-0"></i>
        Nuestro equipo responde en un plazo de 24–48 horas hábiles.
      </div>

      <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'fieldConfig' => [
          'labelOptions' => [
            'class' => 'form-label fw-semibold text-secondary mb-1'
          ],
          'errorOptions' => [
            'class' => 'invalid-feedback'
          ],
        ],
      ]); ?>

      <!-- Nombre y correo -->
      <div class="row g-3 mb-1">
        <div class="col-sm-6">
          <?= $form->field($model, 'name', [
            'inputOptions' => [
              'class' => 'form-control py-2',
              'autofocus' => true,
              'placeholder' => 'Tu nombre completo'
            ]
          ])->label('Nombre') ?>
        </div>

        <div class="col-sm-6">
          <?= $form->field($model, 'email', [
            'inputOptions' => [
              'class' => 'form-control py-2',
              'placeholder' => 'correo@ejemplo.com'
            ]
          ])->label('Correo electrónico') ?>
        </div>
      </div>

      <?= $form->field($model, 'subject', [
        'inputOptions' => [
          'class' => 'form-control py-2',
          'placeholder' => '¿Sobre qué trata tu mensaje?'
        ]
      ])->label('Asunto') ?>

      <?= $form->field($model, 'body', [
        'inputOptions' => [
          'class' => 'form-control py-2',
          'placeholder' => 'Describe tu consulta con el mayor detalle posible...'
        ]
      ])->textarea(['rows' => 5])->label('Mensaje') ?>

      <!-- CAPTCHA -->
      <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
        'template' => '
          <div class="d-flex align-items-center gap-3">
            <div style="border-radius:10px; overflow:hidden; flex-shrink:0;">{image}</div>
            <div class="flex-grow-1">{input}</div>
          </div>',
        'imageOptions' => [
          'style' => 'border-radius:10px;'
        ],
        'options' => [
          'class' => 'form-control py-2',
          'placeholder' => 'Código de verificación'
        ],
      ])->label('Verificación') ?>

      <!-- Botón -->
      <div class="mt-4 d-grid">
        <?= Html::submitButton(
          '<i class="bi bi-send me-2"></i>Enviar mensaje',
          [
            'class' => 'btn btn-dark py-3 fw-semibold',
            'style' => '
              border-radius:12px;
              font-size:16px;
            ',
            'name' => 'contact-button'
          ]
        ) ?>
      </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>

</div>