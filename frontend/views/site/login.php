<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Iniciar sesión';
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
         max-width:460px;
         border-radius:24px;
         background:#ffffff;
         box-shadow:0 20px 60px rgba(0,0,0,.12);
         ">

        <div class="card-body p-5">

            <!-- Encabezado -->
            <div class="text-center mb-4">

                <div class="d-flex justify-content-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                         style="
                         width:80px;
                         height:80px;
                         background:#e2e8f0;
                         ">
                        <i class="bi bi-wind"
                           style="
                           font-size:35px;
                           color:#475569;
                           "></i>
                    </div>
                </div>

                <h1 style="
                    font-size:32px;
                    font-weight:700;
                    color:#0f172a;
                    margin-bottom:5px;">
                    AirWatch
                </h1>

                <p style="
                   color:#64748b;
                   font-size:14px;
                   margin-bottom:0;">
                    Monitoreo inteligente de calidad del aire
                </p>

            </div>

            <!-- 🌈 Barra multicolor AQI -->
            <div class="d-flex gap-1 mb-4">
                <?php
                $colores = [
                    '#1a4d00',
                    '#4caf50',
                    '#ffeb3b',
                    '#ff9800',
                    '#f44336',
                    '#7b1fa2'
                ];

                foreach ($colores as $c): ?>
                    <div style="
                        flex:1;
                        height:5px;
                        border-radius:10px;
                        background:<?= $c ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mb-4 text-center">
                <h4 class="fw-bold mb-1">
                    Bienvenido
                </h4>

                <p class="text-muted mb-0">
                    Inicia sesión para acceder al sistema
                </p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => [
                        'class' => 'form-label fw-semibold text-secondary mb-1'
                    ],
                    'inputOptions' => [
                        'class' => 'form-control py-2'
                    ],
                    'errorOptions' => [
                        'class' => 'invalid-feedback'
                    ],
                ],
            ]); ?>

            <?= $form->field($model, 'username', [
                'inputOptions' => [
                    'class' => 'form-control py-2',
                    'autofocus' => true,
                    'placeholder' => 'Ingrese su usuario',
                ]
            ])->label('Usuario') ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'class' => 'form-control py-2',
                    'placeholder' => 'Ingrese su contraseña',
                ]
            ])->passwordInput()->label('Contraseña') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'label' => 'Recordar mi sesión',
                'class' => 'form-check-input',
            ]) ?>

            <div class="d-grid mt-4">

                <?= Html::submitButton(
                    '<i class="bi bi-box-arrow-in-right me-2"></i>Ingresar al sistema',
                    [
                        'class' => 'btn btn-dark py-3 fw-semibold',
                        'style' => '
                            border-radius:12px;
                            font-size:16px;
                        ',
                        'name' => 'login-button',
                    ]
                ) ?>

            </div>

            <?php ActiveForm::end(); ?>

            <div class="border-top mt-4 pt-4 text-center">

                <?= Html::a(
                    '¿Olvidaste tu contraseña?',
                    ['site/request-password-reset'],
                    [
                        'class' => 'text-decoration-none fw-semibold',
                        'style' => 'color:#475569;'
                    ]
                ) ?>

                <br><br>

                <?= Html::a(
                    'Reenviar correo de verificación',
                    ['site/resend-verification-email'],
                    [
                        'class' => 'text-decoration-none fw-semibold',
                        'style' => 'color:#475569;'
                    ]
                ) ?>

            </div>

        </div>

    </div>

</div>