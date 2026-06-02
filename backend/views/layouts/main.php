<?php
 
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use yii\widgets\Breadcrumbs;
use common\models\PermisosHelpers;
use backend\assets\FontAwesomeAsset;
 
/**
 * @var \yii\web\View $this
 * @var string $content
 */
 
AppAsset::register($this);
FontAwesomeAsset::register($this);
 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if (!Yii::$app->user->isGuest) {
        $es_admin = PermisosHelpers::requerirMinimoRol('Admin');

        NavBar::begin([
            'brandLabel' => 'Yii 2 Build <i class="fa fa-plug"></i> Admin',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                // Clases actualizadas para Bootstrap 5 (Fondo oscuro y posición fija)
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
    } else {
        NavBar::begin([
            'brandLabel' => 'Yii 2 Build <i class="fa fa-plug"></i>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
    }
    
    // Inicializamos el menú de Home
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    
    // Si el usuario está logueado y es administrador, armamos los menús desplegables
    if (!Yii::$app->user->isGuest && isset($es_admin) && $es_admin) {
        
        // -- Menú Desplegable 1: SENSORES Y DISPOSITIVOS --
        $menuItems[] = [
            'label' => 'Monitoreo IoT',
            'items' => [
                ['label' => 'Dispositivos', 'url' => ['/dispositivos/index']],
                ['label' => 'Lecturas Sensores', 'url' => ['/lecturas-sensores/index']],
                ['label' => 'Actuadores', 'url' => ['/estado-actuadores/index']],
                '<div class="dropdown-divider"></div>', // Línea separadora
                ['label' => 'Alertas Historial', 'url' => ['/alertas-historial/index']],
                ['label' => 'Umbrales Configuración', 'url' => ['/umbrales-configuracion/index']],
            ],
        ];

        // -- Menú Desplegable 2: ADMINISTRACIÓN Y USUARIOS --
        $menuItems[] = [
            'label' => 'Administración',
            'items' => [
                ['label' => 'Usuarios', 'url' => ['/user/index']],
                ['label' => 'Perfiles', 'url' => ['/perfil/index']],
                ['label' => 'Roles', 'url' => ['/rol/index']],
                ['label' => 'Tipos de Usuario', 'url' => ['/tipo-usuario/index']],
                '<div class="dropdown-divider"></div>', // Línea separadora
                ['label' => 'Estados del Sistema', 'url' => ['/estado/index']],
            ],
        ];
    }
     
    // Botón de Login / Logout
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    } 
                                                                                                        
    // Imprimir la barra de navegación (alineada a la derecha con ms-auto)
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
   
    NavBar::end();
    ?>
 
    <div class="container" style="padding-top: 80px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
 
<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="text-muted fw-bold">&copy; ING. Angel Manrique Casanova <?= date('Y') ?></span>
        <span class="text-muted small"><?= Yii::powered() ?></span>
    </div>
</footer>
 
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>