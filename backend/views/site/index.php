<?php
use yii\helpers\Html;

$this->title = 'Dashboard Principal';
// Solo agregué esto para que funcionen los iconos
\Yii::$app->view->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css');
?>

<style>
  /* =========================================
     1. BANNER HERO MEJORADO
     ========================================= */
  .hero-banner {
    /* Gradiente más rico y moderno */
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-radius: 20px;
    padding: 3.5rem 2rem;
    color: white;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
  }
  
  /* Patrón sutil de fondo */
  .hero-banner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 0%, transparent 25%),
                      radial-gradient(circle at 80% 70%, rgba(255,255,255,0.05) 0%, transparent 25%);
    pointer-events: none;
  }

  .hero-banner h1 { 
    font-weight: 700; 
    font-size: 2.4rem; 
    margin-bottom: 0.5rem; 
    position: relative;
    z-index: 1;
  }
  .hero-banner p { 
    font-size: 1rem; 
    opacity: 0.85; 
    margin-bottom: 1.5rem; 
    font-weight: 300; 
    position: relative;
    z-index: 1;
  }

  .toggle-container { display: flex; justify-content: center; gap: 1rem; margin-top: 1.5rem; position: relative; z-index: 1; }
  .btn-toggle {
    border-radius: 50px; 
    padding: 0.7rem 2rem; 
    font-weight: 600; 
    font-size: 0.95rem;
    border: 1px solid rgba(255, 255, 255, 0.3); 
    background: rgba(255, 255, 255, 0.08); 
    color: rgba(255, 255, 255, 0.85);
    transition: all 0.3s ease; 
    text-decoration: none; 
    display: inline-flex; 
    align-items: center; 
    gap: 0.5rem;
    cursor: pointer;
  }
  .btn-toggle.active { 
    background: #ffffff; 
    color: #1e293b; 
    border-color: #ffffff; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
  }
  .btn-toggle:hover:not(.active) { 
    background: rgba(255, 255, 255, 0.15); 
    color: white; 
    transform: translateY(-2px);
  }

  /* =========================================
     2. ESTADÍSTICAS MEJORADAS
     ========================================= */
  .stats-row { 
    display: flex; 
    justify-content: space-around; 
    align-items: center; 
    margin-bottom: 3rem; 
    padding: 0 1rem;
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    border: 1px solid #f1f5f9;
  }
  .stat-item { text-align: center; position: relative; padding: 0 1rem; }
  
  /* Línea separadora entre stats */
  .stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: -5px;
    top: 50%;
    transform: translateY(-50%);
    height: 40px;
    width: 1px;
    background: #e2e8f0;
  }

  .stat-icon { 
    font-size: 2rem; 
    margin-bottom: 0.5rem; 
    width: 50px; 
    height: 50px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  
  /* Fondos colorizados para iconos stats */
  .bg-stat-blue    { background: #eff6ff; color: #3b82f6; }
  .bg-stat-green { background: #f0fdf4; color: #22c55e; }
  .bg-stat-yellow{ background: #fefce8; color: #eab308; }

  .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1.2; margin-bottom: 0.2rem; color: #1e293b; }
  .stat-label { font-size: 0.85rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
  
  .text-blue { color: #3b82f6; }
  .text-green { color: #22c55e; }
  .text-yellow { color: #eab308; }

  /* =========================================
     3. TARJETAS MINIMALISTAS MEJORADAS
     ========================================= */
  .dash-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #f4f4f4;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    margin-top: 1rem;
    border-left: 4px solid #3b82f6;
    padding-left: 12px;
  }
  
  .minimal-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    display: flex;
    align-items: flex-start;
    gap: 1.2rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    text-decoration: none;
    height: 100%;
  }
  .minimal-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: #cbd5e1;
    transform: translateY(-4px);
    background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
  }

  .mc-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
    transition: transform 0.3s ease;
  }
  
  .minimal-card:hover .mc-icon {
    transform: scale(1.1) rotate(5deg);
  }
  
  /* Colores más vivos */
  .bg-soft-blue   { background-color: #eff6ff; color: #3b82f6; }
  .bg-soft-orange { background-color: #fff7ed; color: #f97316; }
  .bg-soft-green  { background-color: #f0fdf4; color: #16a34a; }
  .bg-soft-red    { background-color: #fef2f2; color: #ef4444; }
  .bg-soft-purple { background-color: #faf5ff; color: #9333ea; }
  .bg-soft-teal   { background-color: #f0fdfa; color: #14b8a6; }
  .bg-soft-pink   { background-color: #fdf2f8; color: #ec4899; }
  .bg-soft-yellow { background-color: #fefce8; color: #ca8a04; }

  .mc-content h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.4rem;
    margin-top: 0;
  }
  .mc-content p {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 0;
    line-height: 1.5;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .stats-row { flex-direction: column; gap: 1.5rem; }
    .stat-item::after { display: none !important; }
  }
</style>

<div class="site-index">

  <!-- =========================================
       1. BANNER HERO Y BOTONES
       ========================================= -->
  <div class="hero-banner">
    <h1>Sistema de Monitoreo</h1>
    <p>Control y Prevención de la Calidad del Aire</p>
    
<div class="toggle-container">

    <a href="<?= \yii\helpers\Url::to(['site/index', 'periodo' => 'hoy']) ?>"
       class="btn-toggle <?= $periodo == 'hoy' ? 'active' : '' ?>">
        <i class="bi bi-graph-up-arrow"></i> Hoy
    </a>

    <a href="<?= \yii\helpers\Url::to(['site/index', 'periodo' => 'semana']) ?>"
       class="btn-toggle <?= $periodo == 'semana' ? 'active' : '' ?>">
        <i class="bi bi-calendar3"></i> Esta Semana
    </a>

    <a href="<?= \yii\helpers\Url::to(['site/index', 'periodo' => 'global']) ?>"
       class="btn-toggle <?= $periodo == 'global' ? 'active' : '' ?>">
        <i class="bi bi-pie-chart"></i> Global
    </a>

</div>

<!-- ESTADÍSTICAS RÁPIDAS -->
<div class="stats-row">

    <!-- DISPOSITIVOS -->
    <div class="stat-item">
        <div class="stat-icon bg-stat-blue">
            <i class="bi bi-cpu"></i>
        </div>

        <div class="stat-value text-blue">
            <?= number_format($totalDispositivos) ?>
        </div>

        <div class="stat-label">
            Dispositivos
        </div>
    </div>

    <!-- LECTURAS -->
    <div class="stat-item">
        <div class="stat-icon bg-stat-green">
            <i class="bi bi-wind"></i>
        </div>

        <div class="stat-value text-green">
            <?= number_format($totalLecturas) ?>
        </div>

        <div class="stat-label">
            <?=
                $periodo == 'hoy'
                ? 'Lecturas Hoy'
                : ($periodo == 'semana'
                    ? 'Lecturas Semana'
                    : 'Lecturas Globales')
            ?>
        </div>
    </div>

    <!-- ALERTAS -->
    <div class="stat-item">
        <div class="stat-icon bg-stat-yellow">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <div class="stat-value text-yellow">
            <?= number_format($totalAlertas) ?>
        </div>

        <div class="stat-label">
            <?=
                $periodo == 'hoy'
                ? 'Alertas Hoy'
                : ($periodo == 'semana'
                    ? 'Alertas Semana'
                    : 'Alertas Globales')
            ?>
        </div>
    </div>

</div>

  <!-- =========================================
       2. SECCIÓN: MONITOREO IOT
       ========================================= -->
  <h2 class="dash-section-title">Monitoreo IoT</h2>
  
  <div class="row g-4 mb-5">
    
    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <?= Html::a('', ['/dispositivos/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-orange"><i class="bi bi-router"></i></div>
        <div class="mc-content">
          <h3>Dispositivos</h3>
          <p>Administra los módulos ESP32 conectados a la red.</p>
        </div>
      </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <?= Html::a('', ['/lecturas-sensores/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-blue"><i class="bi bi-activity"></i></div>
        <div class="mc-content">
          <h3>Lecturas Sensores</h3>
          <p>Historial en tiempo real de calidad de aire (MQ135 y MQ5).</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <?= Html::a('', ['/estado-actuadores/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-green"><i class="bi bi-sliders2"></i></div>
        <div class="mc-content">
          <h3>Actuadores</h3>
          <p>Estado operativo de LEDs de advertencia y alarmas (Buzzer).</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <?= Html::a('', ['/alertas-historial/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-red"><i class="bi bi-bell"></i></div>
        <div class="mc-content">
          <h3>Alertas</h3>
          <p>Registro histórico de advertencias y estados críticos detectados.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <?= Html::a('', ['/umbrales-configuracion/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-purple"><i class="bi bi-gear"></i></div>
        <div class="mc-content">
          <h3>Umbrales</h3>
          <p>Ajusta los límites matemáticos que disparan las alarmas automáticas.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================
       3. SECCIÓN: ADMINISTRACIÓN
       ========================================= -->
  <h2 class="dash-section-title">Administración y Accesos</h2>
  
  <div class="row g-4 mb-5">
    
    <div class="col-md-6 col-lg-3">
      <div class="minimal-card">
        <?= Html::a('', ['/user/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-teal"><i class="bi bi-people"></i></div>
        <div class="mc-content">
          <h3>Usuarios</h3>
          <p>Cuentas de acceso al sistema.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="minimal-card">
        <?= Html::a('', ['/rol/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-pink"><i class="bi bi-shield-lock"></i></div>
        <div class="mc-content">
          <h3>Roles</h3>
          <p>Control de permisos y seguridad.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="minimal-card">
        <?= Html::a('', ['/perfil/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-yellow"><i class="bi bi-person-lines-fill"></i></div>
        <div class="mc-content">
          <h3>Perfiles</h3>
          <p>Información del personal técnico.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="minimal-card">
        <?= Html::a('', ['/tipo-usuario/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-blue"><i class="bi bi-tags"></i></div>
        <div class="mc-content">
          <h3>Tipos Usuario</h3>
          <p>Clasificación departamental.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="minimal-card">
        <?= Html::a('', ['/estado/index'], ['class' => 'stretched-link']) ?>
        <div class="mc-icon bg-soft-purple"><i class="bi bi-toggle-on"></i></div>
        <div class="mc-content">
          <h3>Estados de sistema</h3>
          <p>Estados lógicos de operación.</p>
        </div>
      </div>
    </div>

  </div>

</div>  