<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;

/** @var yii\web\View $this */

$this->title = 'Yii 2 Build - Inicio';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>¡Bienvenido a Yii 2 Build!</h1>

        <p class="lead">La aplicación donde gestionas tu perfil y nivel de acceso.</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <p><?= Html::a('Comenzar ahora', ['site/signup'], ['class' => 'btn btn-lg btn-success']) ?></p>
        <?php else: ?>
            <p><?= Html::a('Ir a mi Perfil', ['perfil/view'], ['class' => 'btn btn-lg btn-primary']) ?></p>
        <?php endif; ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Control de Acceso</h2>
                <p>Nuestra IA y el sistema de permisos aseguran que tu contenido esté protegido según tu nivel de cuenta.</p>
            </div>
            <div class="col-lg-4">
                <h2>Estado de Cuenta</h2>
                <p>Recuerda que para editar ciertos datos necesitas subir de nivel a cuenta <strong>Pago</strong>.</p>
            </div>
            <div class="col-lg-4">
                <h2>Soporte</h2>
                <p>Si tienes problemas con tu registro o el proceso de upgrade, contacta a nuestro equipo técnico.</p>
            </div>
        </div>
    </div>
</div>