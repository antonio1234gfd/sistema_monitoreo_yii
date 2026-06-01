<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Crear cuenta';
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
                        <i class="bi bi-person-plus"
                           style="
                           font-size:35px;
                           color:#475569;
                           "></i>
                    </div>
                </div>

                <h1 style="
                    font-size:30px;
                    font-weight:700;
                    color:#0f172a;
                    margin-bottom:5px;">
                    Crear cuenta
                </h1>

                <p style="
                   color:#64748b;
                   font-size:14px;
                   margin-bottom:0;">
                    Regístrate en el sistema AirWatch
                </p>

            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
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

            <?= $form->field($model, 'email', [
                'inputOptions' => [
                    'class' => 'form-control py-2',
                    'placeholder' => 'Ingrese su correo',
                ]
            ])->label('Correo electrónico') ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'class' => 'form-control py-2',
                    'placeholder' => 'Ingrese su contraseña',
                ]
            ])->passwordInput()->label('Contraseña') ?>

            <div class="d-grid mt-4">

                <?= Html::submitButton(
                    '<i class="bi bi-person-plus me-2"></i>Crear cuenta',
                    [
                        'class' => 'btn btn-dark py-3 fw-semibold',
                        'style' => '
                            border-radius:12px;
                            font-size:16px;
                        ',
                        'name' => 'signup-button'
                    ]
                ) ?>

            </div>

            <?php ActiveForm::end(); ?>

            <div class="border-top mt-4 pt-4 text-center">

                <small class="text-muted">
                    ¿Ya tienes una cuenta?
                    <?= Html::a(
                        'Iniciar sesión',
                        ['site/login'],
                        [
                            'class' => 'fw-semibold text-decoration-none',
                            'style' => 'color:#475569;'
                        ]
                    ) ?>
                </small>

            </div>

        </div>

    </div>

</div>