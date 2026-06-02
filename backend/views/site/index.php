<?php
use yii\helpers\Html;

$this->title = 'Dashboard Principal';
?>

<style>
  /* =========================================
     1. BANNER HERO Y ESTADÍSTICAS (Tu diseño original)
     ========================================= */
  .hero-banner {
    background: linear-gradient(135deg, #2b3048 0%);
    border-radius: 16px;
    padding: 3rem 2rem 2rem 2rem;
    color: white;
    text-align: center;
    box-shadow: 0 10px 30px rgba(118, 75, 162, 0.15);
    margin-bottom: 2rem;
  }
  .hero-banner h1 { font-weight: 700; font-size: 2.2rem; margin-bottom: 0.5rem; }
  .hero-banner p { font-size: 0.95rem; opacity: 0.85; margin-bottom: 1.5rem; font-weight: 300; }

  .toggle-container { display: flex; justify-content: center; gap: 1rem; margin-top: 1.5rem; }
  .btn-toggle {
    border-radius: 50px; padding: 0.6rem 1.8rem; font-weight: 600; font-size: 0.95rem;
    border: 1px solid rgba(255, 255, 255, 0.4); background: transparent; color: white;
    transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
  }
  .btn-toggle.active { background: #ffffff; color: #1e293b; border-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
  .btn-toggle:hover:not(.active) { background: rgba(255, 255, 255, 0.1); color: white; }

  .stats-row { display: flex; justify-content: space-around; align-items: center; margin-bottom: 3.5rem; padding: 0 1rem; }
  .stat-item { text-align: center; }
  .stat-icon { font-size: 2.2rem; margin-bottom: 0.5rem; }
  .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1.2; margin-bottom: 0.2rem; color: #1e293b; }
  .stat-label { font-size: 0.85rem; color: #64748b; font-weight: 500; }
  
  .text-blue { color: #3b82f6; }
  .text-green { color: #22c55e; }
  .text-yellow { color: #f59e0b; }

  /* =========================================
     2. TARJETAS MINIMALISTAS Y LIMPIAS (Clean UI)
     ========================================= */
  .dash-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    margin-top: 1rem;
  }
  
  .minimal-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: flex-start;
    gap: 1.2rem;
    transition: all 0.2s ease;
    position: relative; /* Necesario para stretched-link */
    text-decoration: none;
    height: 100%;
  }
  .minimal-card:hover {
    box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.05);
    border-color: #e2e8f0;
    transform: translateY(-3px);
  }

  .mc-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }
  
  /* Colores pastel muy suaves para no cansar la vista */
  .bg-soft-blue   { background-color: #eff6ff; color: #3b82f6; }
  .bg-soft-orange { background-color: #fff7ed; color: #f97316; }
  .bg-soft-green  { background-color: #f0fdf4; color: #22c55e; }
  .bg-soft-red    { background-color: #fef2f2; color: #ef4444; }
  .bg-soft-purple { background-color: #faf5ff; color: #a855f7; }
  .bg-soft-teal   { background-color: #f0fdfa; color: #14b8a6; }
  .bg-soft-pink   { background-color: #fdf2f8; color: #ec4899; }
  .bg-soft-yellow { background-color: #fefce8; color: #eab308; }

  .mc-content h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.3rem;
    margin-top: 0;
  }
  .mc-content p {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 0;
    line-height: 1.4;
  }
</style>

<div class="site-index">

  <!-- =========================================
       1. BANNER HERO Y BOTONES (TU DISEÑO)
       ========================================= -->
  <div class="hero-banner">
    <h1>Dashboard Sistema de Monitoreo</h1>
    <p>Sistema de Monitoreo de la Calidad del Aire</p>
  </div>

  <!-- =========================================
       3. SECCIÓN: SENSORES IOT
       ========================================= -->
  <h2 class="dash-section-title">Monitoreo IoT</h2>
  
  <div class="row g-4 mb-5">
    
    <div class="col-md-6 col-lg-4">
      <div class="minimal-card">
        <!-- El stretched-link hace que toda la tarjeta sea clickable -->
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
       4. SECCIÓN: ADMINISTRACIÓN
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
        <div class="mc-icon bg-soft-blue"><i class="bi bi-tags"></i></div>
        <div class="mc-content">
          <h3>Estados de sistema</h3>
          <p>PENDIENTE.................</p>
        </div>
      </div>
    </div>

  </div>

</div>