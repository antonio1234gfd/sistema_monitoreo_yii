<?php

use yii\helpers\Html;
use common\models\PermisosHelpers;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

$this->title = 'Dashboard IRE - Monitoreo';
$es_admin = PermisosHelpers::requerirMinimoRol('Admin');

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css');
?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        --electric-gradient: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
        --sensor-gradient: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        --actuator-gradient: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
        --shadow: 0 20px 40px rgba(0,0,0,0.1);
        --shadow-hover: 0 30px 60px rgba(0,0,0,0.2);
    }

    .dashboard-hero {
        background: var(--primary-gradient);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff15"><polygon points="0,100 1000,0 1000,100"/></svg>');
        pointer-events: none;
    }

    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
        background: white;
        position: relative;
    }

    .card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .card-modern:hover {
        transform: translateY(-15px);
        box-shadow: var(--shadow-hover);
    }

    .card-modern:hover::before {
        transform: scaleX(1);
    }

    .card-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin-bottom: 1.5rem;
    }

    /* Iconos Originales */
    .card-users { background: var(--success-gradient); }
    .card-roles { background: var(--secondary-gradient); }
    .card-profiles { background: var(--warning-gradient); }
    .card-tipos { background: var(--danger-gradient); }
    .card-estados { background: var(--dark-gradient); }

    /* NUEVOS ICONOS */
    .card-dispositivos { background: var(--electric-gradient); }
    .card-lecturas { background: var(--sensor-gradient); }
    .card-actuadores { background: var(--actuator-gradient); }
    .card-alertas { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
    .card-umbrales { background: linear-gradient(135deg, #ff9a8b 0%, #fecfef 100%); }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.2);
    }

    @media (max-width: 768px) {
        .dashboard-hero { padding: 2rem 0; margin-bottom: 2rem; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container-fluid px-4">
   
    <div class="dashboard-hero text-center position-relative">
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-tachometer-alt me-3"></i>
                Dashboard Sistema de Monitoreo en Tiempo Real
            </h1>
            <p class="lead mb-4 opacity-90">
                Sistema de Monitoreo en Tiempo Real - Infraestructura de Red Eléctrica
            </p>
            <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?= Url::to(['user/index']) ?>" class="btn btn-light btn-lg px-5 py-2 rounded-pill shadow-lg">
                        <i class="fas fa-users me-2"></i>Usuarios
                    </a>
                    <a href="<?= Url::to(['dispositivos/index']) ?>" class="btn btn-outline-light btn-lg px-5 py-2 rounded-pill shadow-lg">
                        <i class="fas fa-microchip me-2"></i>Dispositivos
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-bolt text-primary fs-1 mb-3"></i>
            <h3 class="fw-bold text-primary">247</h3>
            <p class="mb-0 text-muted">Subestaciones Activas</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-plug text-success fs-1 mb-3"></i>
            <h3 class="fw-bold text-success">99.8%</h3>
            <p class="mb-0 text-muted">Disponibilidad</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-microchip text-warning fs-1 mb-3"></i>
            <h3 class="fw-bold text-warning">1,247</h3>
            <p class="mb-0 text-muted">Dispositivos Online</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-chart-line text-info fs-1 mb-3"></i>
            <h3 class="fw-bold text-info">1.2 MW</h3>
            <p class="mb-0 text-muted">Consumo Actual</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-exclamation-triangle text-danger fs-1 mb-3"></i>
            <h3 class="fw-bold text-danger">3</h3>
            <p class="mb-0 text-muted">Alertas Activas</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-database text-electric fs-1 mb-3"></i>
            <h3 class="fw-bold text-electric">45,672</h3>
            <p class="mb-0 text-muted">Lecturas Hoy</p>
        </div>
    </div>

    <!-- Primera Fila: Administración -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Gestión de Usuarios</h5>
                    <p class="card-text text-muted small mb-4">Administra operadores y técnicos</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Panel Usuarios', ['user/index'], ['class' => 'btn btn-success w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-roles">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3 text-danger">Control de Roles</h5>
                    <p class="card-text text-muted small mb-4">Permisos y accesos</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Gestionar Roles', ['rol/index'], ['class' => 'btn btn-danger w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-profiles">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3 text-warning">Perfiles</h5>
                    <p class="card-text text-muted small mb-4">Información del personal</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Ver Perfiles', ['perfil/index'], ['class' => 'btn btn-warning w-100 rounded-pill py-2 fw-bold small text-dark']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-tipos">
                    <i class="fas fa-user-tag"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Tipos Usuario</h5>
                    <p class="card-text text-muted small mb-4">Clasificación por función</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Configurar', ['tipo-usuario/index'], ['class' => 'btn btn-outline-danger w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda Fila: Administración Técnica -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-estados">
                    <i class="fas fa-toggle-on"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3 text-primary">Estados Sistema</h5>
                    <p class="card-text text-muted small mb-4">Estados operativos</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Panel Estados', ['estado/index'], ['class' => 'btn btn-primary w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- NUEVO: Dispositivos -->
        <div class="col-lg-3 col-md-6">  
            <div class="card-modern h-100">
                <div class="card-icon card-dispositivos">
                    <i class="fas fa-microchip"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Dispositivos IoT</h5>
                    <p class="card-text text-muted small mb-4">Sensores y equipos conectados</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Gestionar Dispositivos', ['dispositivos/index'], ['class' => 'btn btn-warning w-100 rounded-pill py-2 fw-bold small text-dark']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- NUEVO: Lecturas -->
        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-lecturas">
                    <i class="fas fa-chart-area"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3 text-info">Lecturas Sensores</h5>
                    <p class="card-text text-muted small mb-4">Datos en tiempo real</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Ver Lecturas', ['lecturas-sensores/index'], ['class' => 'btn btn-info w-100 rounded-pill py-2 fw-bold small text-white']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- NUEVO: Actuadores -->
        <div class="col-lg-3 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-actuadores">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Actuadores</h5>
                    <p class="card-text text-muted small mb-4">Control remoto equipos</p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Control Actuadores', ['estado-actuadores/index'], ['class' => 'btn btn-success w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tercera Fila: Monitoreo Crítico -->
    <div class="row g-4">
        <!-- NUEVO: Alertas -->
        <div class="col-lg-4 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-alertas">
                    <i class="fas fa-bell me-1"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3 text-danger">Centro Alertas</h5>
                    <p class="card-text text-muted small mb-4">
                        Notificaciones críticas en tiempo real
                    </p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Ver Alertas (3 Activas)', ['alertas-historial/index'], [
                            'class' => 'btn btn-danger w-100 rounded-pill py-2 fw-bold small',
                            'style' => 'animation: pulse 2s infinite;'
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- NUEVO: Umbrales -->
        <div class="col-lg-4 col-md-6">
            <div class="card-modern h-100">
                <div class="card-icon card-umbrales">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Umbrales Críticos</h5>
                    <p class="card-text text-muted small mb-4">
                        Configuración de límites y triggers
                    </p>
                    <?php if (!Yii::$app->user->isGuest && $es_admin): ?>
                        <?= Html::a('→ Configurar Umbrales', ['umbrales-configuracion/index'], ['class' => 'btn btn-outline-primary w-100 rounded-pill py-2 fw-bold small']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card-modern h-100 text-center p-4">
                <div class="card-icon" style="background: var(--primary-gradient); width: 100px; height: 100px; margin: 0 auto 1.5rem;">
                    <i class="fas fa-rocket fs-1"></i>
                </div>
                <h3 class="fw-bold mb-3 text-primary">Sistema Operativo</h3>
                <p class="text-muted mb-4">¡Todo bajo control! 99.8% uptime</p>
                <div class="progress mx-auto" style="width: 80%; height: 8px;">
                    <div class="progress-bar bg-success" style="width: 99.8%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>