<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
$this->title = 'Acerca del Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.about-wrap { max-width: 800px; margin: 2rem auto; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; color: #333; }

.about-header { border-bottom: 2px solid #333; padding-bottom: 1rem; margin-bottom: 2rem; }
.about-header h1 { font-size: 1.8rem; font-weight: 700; color: #000; margin: 0; }
.about-header .sub { font-size: 0.9rem; color: #666; margin-top: 0.5rem; }

.about-card { background: #fff; padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; }
.about-card h4 { font-size: 0.9rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; }

.sensor-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.sensor-item { border: 1px solid #eee; padding: 1rem; display: flex; align-items: center; gap: 1rem; }
.sensor-name { font-weight: 700; color: #000; }
.sensor-desc { font-size: 0.85rem; color: #666; }

.status-list { list-style: none; padding: 0; margin: 0; }
.status-item { display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem; }
.dot { width: 10px; height: 10px; border-radius: 50%; }
.dot-ok { background: #28a745; }
.dot-alert { background: #dc3545; }

.about-firma { text-align: center; font-size: 0.8rem; color: #999; margin-top: 3rem; }

@media (max-width: 600px) { .sensor-grid { grid-template-columns: 1fr; } }
</style>

<div class="about-wrap">
    <div class="about-header">
        <h1>Acerca del Sistema</h1>
        <div class="sub">Sistema de Monitoreo de Seguridad Industrial y Calidad de Aire</div>
    </div>

    <div class="about-card">
        <h4>Descripción</h4>
        <p>Plataforma de monitoreo IoT desarrollada con <strong>Yii2</strong> para la supervisión en tiempo real de contaminantes y riesgos de fugas de gas, utilizando hardware <strong>ESP32</strong> para la recolección de datos críticos.</p>
    </div>

    <div class="about-card">
        <h4>Sensores</h4>
        <div class="sensor-grid">
            <div class="sensor-item">
                <div class="sensor-name">MQ-135</div>
                <div class="sensor-desc">Monitoreo de calidad de aire (CO₂ y vapores).</div>
            </div>
            <div class="sensor-item">
                <div class="sensor-name">MQ-5</div>
                <div class="sensor-desc">Detección de gases inflamables (GLP/GN).</div>
            </div>
        </div>
    </div>

    <div class="about-card">
        <h4>Indicadores de Estado</h4>
        <ul class="status-list">
            <li class="status-item"><div class="dot dot-ok"></div> Niveles normales (Rango seguro)</li>
            <li class="status-item"><div class="dot dot-alert"></div> Alerta activa (Activación de protocolos de seguridad)</li>
        </ul>
    </div>

    <div class="about-card">
        <h4>Características</h4>
        <ul>
            <li>Monitoreo simultáneo de gases y calidad de aire.</li>
            <li>Alertas automatizadas mediante triggers en base de datos.</li>
            <li>Dashboard responsivo con visualización en tiempo real.</li>
            <li>Sistema de control de acceso (RBAC) para seguridad.</li>
        </ul>
    </div>

</div>