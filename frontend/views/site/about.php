<?php

/** @var \yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Acerca de';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@400;600;700&display=swap');

.about-wrap {
    max-width: 860px;
    margin: 2.5rem auto;
    font-family: 'Rajdhani', sans-serif;
}

.about-header {
    border-left: 4px solid #0077b6;
    padding-left: 1.2rem;
    margin-bottom: 2rem;
}

.about-header h1 {
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #0077b6;
    margin-bottom: 0.2rem;
}

.about-header .sub {
    font-family: 'Share Tech Mono', monospace;
    font-size: 0.75rem;
    color: #6c757d;
    letter-spacing: 2px;
}

.about-card {
    border: 1px solid #dee2e6;
    border-left: 4px solid #0077b6;
    border-radius: 0;
    padding: 1.5rem 1.8rem;
    margin-bottom: 1.4rem;
    background: #f8f9fa;
}

.about-card h4 {
    font-family: 'Share Tech Mono', monospace;
    font-size: 0.75rem;
    letter-spacing: 3px;
    color: #0077b6;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.about-card p,
.about-card li {
    font-size: 1.05rem;
    color: #343a40;
    line-height: 1.6;
}

.about-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.about-card ul li::before {
    content: '▸ ';
    color: #0077b6;
    font-weight: bold;
}

/* Badges de sensores */
.sensor-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.sensor-item {
    background: #fff;
    border: 1px solid #dee2e6;
    padding: 1rem 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sensor-icon {
    font-size: 1.8rem;
    line-height: 1;
}

.sensor-name {
    font-family: 'Share Tech Mono', monospace;
    font-size: 0.9rem;
    font-weight: bold;
    color: #0077b6;
}

.sensor-desc {
    font-size: 0.9rem;
    color: #6c757d;
    margin-top: 2px;
}

/* LED indicators */
.led-grid {
    display: flex;
    gap: 1.2rem;
    flex-wrap: wrap;
}

.led-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1rem;
    color: #343a40;
}

.led-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
}

.led-verde   { background: #00e676; box-shadow: 0 0 6px #00e67688; }
.led-amarillo{ background: #ffea00; box-shadow: 0 0 6px #ffea0088; }
.led-rojo    { background: #ff1744; box-shadow: 0 0 6px #ff174488; }

/* Footer firma */
.about-firma {
    font-family: 'Share Tech Mono', monospace;
    font-size: 0.72rem;
    letter-spacing: 2px;
    color: #6c757d;
    text-align: center;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

@media (max-width: 576px) {
    .sensor-grid { grid-template-columns: 1fr; }
    .led-grid    { flex-direction: column; }
}
</style>

<div class="about-wrap">

    <!-- Header -->
    <div class="about-header">
        <h1>Acerca del Sistema</h1>
        <div class="sub">// SISTEMA DE MONITOREO DE CALIDAD DEL AIRE — YII2 ADVANCED</div>
    </div>

    <!-- Descripción general -->
    <div class="about-card">
        <h4>// descripción</h4>
        <p>
            Aplicación web desarrollada con <strong>Yii2 Advanced</strong> que integra la gestión
            de usuarios con el monitoreo en tiempo real de la calidad del aire mediante
            dispositivos <strong>ESP32</strong>. Permite visualizar lecturas de sensores,
            recibir alertas automáticas y conocer el estado del sistema en todo momento.
        </p>
    </div>

    <!-- Sensores -->
    <div class="about-card">
        <h4>// sensores utilizados</h4>
        <div class="sensor-grid">
            <div class="sensor-item">
                <div class="sensor-icon">&#127788;</div>
                <div>
                    <div class="sensor-name">MQ-5</div>
                    <div class="sensor-desc">Calidad del aire — CO₂</div>
                </div>
            </div>
            <div class="sensor-item">
                <div class="sensor-icon">&#127788;</div>
                <div>
                    <div class="sensor-name">MQ-135</div>
                    <div class="sensor-desc">Gases - Butano, Propano</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicador LED -->
    <div class="about-card">
        <h4>// indicador LED de calidad</h4>
        <div class="led-grid">
            <div class="led-item">
                <div class="led-dot led-verde"></div>
                <span><strong>Verde</strong> — Aire limpio</span>
            </div>
            <div class="led-item">
                <div class="led-dot led-amarillo"></div>
                <span><strong>Amarillo</strong> — Aire viciado</span>
            </div>
            <div class="led-item">
                <div class="led-dot led-rojo"></div>
                <span><strong>Rojo</strong> — Contaminación crítica + Buzzer</span>
            </div>
        </div>
    </div>

    <!-- Características -->
    <div class="about-card">
        <h4>// características del sistema</h4>
        <ul>
            <li>Control de acceso por roles: User, Admin y SuperUsuario</li>
            <li>Dashboard de monitoreo con lectura de sensores en tiempo real</li>
            <li>Alertas automáticas generadas por trigger en la base de datos</li>
            <li>Buzzer activado automáticamente en niveles críticos de contaminación</li>
            <li>Historial de lecturas y alertas almacenado en MySQL</li>
            <li>Panel de administración para gestión de usuarios, roles y dispositivos</li>
        </ul>
    </div>

    <!-- Tecnologías -->
    <div class="about-card">
        <h4>// tecnologías utilizadas</h4>
        <ul>
            <li>Backend & Frontend: PHP 8 + Yii2 Advanced Framework</li>
            <li>Base de datos: MySQL 8 con triggers y stored procedures</li>
            <li>Hardware: ESP32 con sensores MQ5 y MQ135</li>
            <li>Gráficas: Chart.js</li>
            <li>UI: Bootstrap 5</li>
        </ul>
    </div>
</div>