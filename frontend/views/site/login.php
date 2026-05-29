<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Iniciar sesión';
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card border-0 shadow-sm" style="width: 100%; max-width: 400px; border-radius: 16px;">
    <div class="card-body p-4">

      <!-- Encabezado de marca -->
      <div class="d-flex align-items-center gap-3 mb-3">
        <div class="d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10"
             style="width: 44px; height: 44px;">
          <i class="bi bi-wind text-success fs-5"></i>
        </div>
        <div>
          <div class="fw-semibold text-dark" style="font-size: 15px;">AirWatch</div>
          <div class="text-muted" style="font-size: 11px;">Sistema de monitoreo de calidad del aire</div>
        </div>
      </div>

      <!-- Barra de índice AQI decorativa -->
      <div class="d-flex gap-1 mb-4">
        <?php
        $colores = ['#1a4d00','#4caf50','#ffeb3b','#ff9800','#f44336','#7b1fa2'];
        foreach ($colores as $c): ?>
          <div style="flex:1; height:4px; border-radius:2px; background:<?= $c ?>"></div>
        <?php endforeach; ?>
      </div>

      <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
          'template'  => "{label}\n{input}\n{error}",
          'labelOptions' => ['class' => 'form-label text-muted small mb-1'],
          'inputOptions' => ['class' => 'form-control'],
          'errorOptions' => ['class' => 'invalid-feedback'],
        ],
      ]); ?>

        <?= $form->field($model, 'username', [
          'inputOptions' => [
            'class'       => 'form-control',
            'autofocus'   => true,
            'placeholder' => 'Tu nombre de usuario',
          ]
        ])->label('👤 Usuario') ?>

        <?= $form->field($model, 'password', [
          'inputOptions' => [
            'class'       => 'form-control',
            'placeholder' => '••••••••',
          ]
        ])->passwordInput()->label('🔒 Contraseña') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
          'label' => 'Recordar mi sesión',
          'class' => 'form-check-input',
        ]) ?>

        <div class="d-grid mt-3">
          <?= Html::submitButton(
            '<i class="bi bi-box-arrow-in-right me-2"></i>Ingresar al sistema',
            [
              'class' => 'btn btn-success',
              'name'  => 'login-button',
            ]
          ) ?>
        </div>

      <?php ActiveForm::end(); ?>

      <!-- Links secundarios -->
      <div class="border-top mt-4 pt-3 d-flex flex-column gap-2">
        <small class="text-muted">
          <i class="bi bi-key me-1"></i>
          ¿Olvidaste tu contraseña?
          <?= Html::a('Restablecer', ['site/request-password-reset'], ['class' => 'text-success fw-semibold text-decoration-none']) ?>
        </small>
        <small class="text-muted">
          <i class="bi bi-envelope me-1"></i>
          ¿Necesitas verificación?
          <?= Html::a('Reenviar correo', ['site/resend-verification-email'], ['class' => 'text-success fw-semibold text-decoration-none']) ?>
        </small>
      </div>

    </div>
  </div>
</div>