<?php
use yii\helpers\Html;

$this->title = 'Inicio - Sistema de Monitoreo';
?>

<style>
  /* ── BANNER HERO DEGRADADO (Estilo profesional) ── */
  .hero-banner {
    background: linear-gradient(135deg, #2b3048 0%);
    border-radius: 20px;
    padding: 3.5rem 2rem;
    color: white;
    text-align: center;
    box-shadow: 0 10px 25px rgba(118, 75, 162, 0.2);
    margin-bottom: 3rem;
  }
  .hero-banner h1 { font-weight: 800; font-size: 2.2rem; margin-bottom: 0.5rem; }
  .hero-banner p { font-size: 1rem; opacity: 0.9; margin-bottom: 2rem; font-weight: 300; }

  .btn-hero {
    border-radius: 50px;
    padding: 0.7rem 2rem;
    font-weight: 600;
    background: #ffffff;
    color: #764ba2;
    border: none;
    transition: transform 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-hero:hover { transform: scale(1.05); color: #764ba2; }

  /* ── FILA DE ESTADÍSTICAS ── */
  .stats-row {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-bottom: 3rem;
    padding: 1rem;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }
  .stat-item { text-align: center; padding: 1rem; }
  .stat-icon { font-size: 2rem; margin-bottom: 0.5rem; }
  .stat-value { font-size: 1.6rem; font-weight: 700; color: #1e293b; }
  .stat-label { font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
  
  .text-blue   { color: #007bff; }
  .text-green  { color: #28a745; }
  .text-yellow { color: #ffc107; }
</style>

<div class="site-index">

    <div class="hero-banner">
        <h1>Dashboard Sistema de Monitoreo</h1>
        <p>Sistema de Monitoreo de la Calidad del Aire - Infraestructura IoT</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Registrarse', ['site/signup'], ['class' => 'btn-hero']) ?>
        <?php else: ?>
            <?= Html::a('Ir a Monitor', ['/dashboard'], ['class' => 'btn-hero']) ?>
        <?php endif; ?>
    </div>

</div>