<?php
/** @var \yii\web\View $this */
use yii\bootstrap5\Html;

$this->title = 'Acerca de';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Outfit:wght@300;400;500;600&display=swap');

:root {
    --cream:  #f5f0e8;
    --ink:    #1a1714;
    --rust:   #c94f2a;
    --mid:    #7a6f62;
    --line:   #c8bfaf;
    --warm:   #e8dcc8;
}

.ed-wrap { background: var(--cream); padding: 3rem 4rem; font-family: 'Outfit', sans-serif; color: var(--ink); min-height: 100vh; }
.ed-inner { max-width: 1100px; margin: 0 auto; }

/* Tipografía y Estructura */
.ed-topbar { display: flex; align-items: center; justify-content: space-between; border-top: 3px solid var(--ink); border-bottom: 2px solid var(--line); padding: 1rem 0; margin-bottom: 3rem; }
.ed-topbar-tag { font-family: 'DM Mono', monospace; font-size: 1.1rem; letter-spacing: .1em; color: var(--mid); text-transform: uppercase; }
.ed-topbar-vol { font-family: 'DM Serif Display', serif; font-size: 1.8rem; color: var(--rust); }

.ed-big-title { font-family: 'DM Serif Display', serif; font-size: 6rem; line-height: 1; color: var(--ink); margin: 0; }
.ed-big-title em { font-style: italic; color: var(--rust); }

.ed-desc-label { font-family: 'DM Mono', monospace; font-size: 1rem; letter-spacing: .2em; color: var(--rust); margin-bottom: 1rem; }
.ed-desc-body { font-size: 1.6rem; line-height: 1.6; color: #3a3530; border-left: 4px solid var(--rust); padding-left: 1.5rem; }

.ed-sec-num { font-family: 'DM Serif Display', serif; font-size: 4rem; color: var(--line); margin-right: 1.5rem; }
.ed-sec-label { font-family: 'DM Mono', monospace; font-size: 1.2rem; letter-spacing: .2em; text-transform: uppercase; color: var(--mid); }

/* Sensores y LEDs */
.ed-sensor-id { font-family: 'DM Serif Display', serif; font-size: 3rem; color: var(--ink); }
.ed-sensor-desc { font-size: 1.4rem; color: var(--mid); margin-top: 0.5rem; }
.ed-sensors-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.ed-sensor-box { border: 2px solid var(--line); padding: 2rem; background: #fff; }

.ed-led-row { display: flex; align-items: center; gap: 1.5rem; padding: 1.2rem; background: #fff; border: 1px solid var(--line); margin-bottom: 0.8rem; }
.ed-led-circle { width: 25px; height: 25px; border-radius: 50%; }
.ed-led-g { background: #2db77b; }
.ed-led-y { background: #e8a825; }
.ed-led-r { background: #d94040; }
.ed-led-name { font-size: 1.4rem; font-weight: 600; width: 120px; }
.ed-led-ppm { font-size: 1.3rem; color: var(--mid); }

.ed-feat-list li { font-size: 1.5rem; padding: 1.2rem 0; border-bottom: 1px solid var(--warm); }
.ed-tech-name { font-size: 1.4rem; }
.ed-tech-tag { font-size: 1rem; padding: 0.3rem 0.8rem; }
.ed-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 3rem; }
.ed-div-thick { height: 4px; background: var(--ink); margin: 3rem 0; }

/* Footer */
.ed-footer { margin-top: 5rem; padding-top: 2rem; border-top: 3px solid var(--ink); display: flex; justify-content: space-between; align-items: center; }
.ed-footer-name { font-family: 'DM Serif Display', serif; font-size: 2.2rem; color: var(--ink); }
.ed-footer-meta { font-family: 'DM Mono', monospace; font-size: 1.1rem; letter-spacing: .1em; color: var(--mid); }
</style>

<div class="ed-wrap">
    <div class="ed-inner">
        <div class="ed-topbar">
            <span class="ed-topbar-tag">Sistema de monitoreo de calidad del aire</span>
            <span class="ed-topbar-vol">Vol. I</span>
        </div>

        <div class="ed-hero-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            <div><h1 class="ed-big-title">Acerca<br>del <em>Sistema</em></h1></div>
            <div>
                <div class="ed-desc-label">Descripción</div>
                <p class="ed-desc-body">Aplicación web desarrollada con <strong>Yii2 Advanced</strong> que integra la gestión de usuarios con el monitoreo en tiempo real de la calidad del aire mediante dispositivos <strong>ESP32</strong>.</p>
            </div>
        </div>

        <div class="ed-div-thick"></div>

        <div class="ed-sec-head" style="display: flex; align-items: baseline; margin-bottom: 2rem;">
            <span class="ed-sec-num">01</span><span class="ed-sec-label">Sensores utilizados</span>
        </div>
        <div class="ed-sensors-grid">
            <div class="ed-sensor-box"><div class="ed-sensor-id">MQ-135</div><div class="ed-sensor-desc">Calidad del aire: CO₂ y gases (ppm)</div></div>
            <div class="ed-sensor-box"><div class="ed-sensor-id">DHT-22</div><div class="ed-sensor-desc">Temperatura (°C) y Humedad relativa (%)</div></div>
        </div>

        <div class="ed-sec-head" style="display: flex; align-items: baseline; margin-top: 3rem; margin-bottom: 2rem;">
            <span class="ed-sec-num">02</span><span class="ed-sec-label">Indicadores LED</span>
        </div>
        <div class="ed-led-section">
            <div class="ed-led-row"><div class="ed-led-circle ed-led-g"></div><span class="ed-led-name">Verde</span><span class="ed-led-ppm">&lt; 700 ppm &mdash; Aire limpio</span></div>
            <div class="ed-led-row"><div class="ed-led-circle ed-led-y"></div><span class="ed-led-name">Amarillo</span><span class="ed-led-ppm">700-999 ppm &mdash; Aire viciado</span></div>
            <div class="ed-led-row"><div class="ed-led-circle ed-led-r"></div><span class="ed-led-name">Rojo</span><span class="ed-led-ppm">1000+ ppm &mdash; Crítico + Buzzer</span></div>
        </div>

        <div class="ed-two-col">
            <div>
                <div class="ed-sec-head" style="display: flex; align-items: baseline;"><span class="ed-sec-num">03</span><span class="ed-sec-label">Características</span></div>
                <ul class="ed-feat-list" style="list-style: none; padding: 0;">
                    <li>Control de acceso: User, Admin, SuperUsuario</li>
                    <li>Dashboard con lecturas en tiempo real</li>
                    <li>Alertas automáticas vía base de datos</li>
                    <li>Buzzer para niveles críticos</li>
                </ul>
            </div>
            <div>
                <div class="ed-sec-head" style="display: flex; align-items: baseline;"><span class="ed-sec-num">04</span><span class="ed-sec-label">Tecnologías</span></div>
                <div class="ed-tech-col" style="margin-top: 1rem;">
                    <div class="ed-tech-row" style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #ccc;"><span class="ed-tech-name">PHP 8 / Yii2 Advanced</span><span class="ed-tech-tag">BACKEND</span></div>
                    <div class="ed-tech-row" style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #ccc;"><span class="ed-tech-name">MySQL 8 / Triggers</span><span class="ed-tech-tag">DATABASE</span></div>
                    <div class="ed-tech-row" style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #ccc;"><span class="ed-tech-name">ESP32 Hardware</span><span class="ed-tech-tag">IOT</span></div>
                </div>
            </div>
        </div>

        <div class="ed-footer">
            <span class="ed-footer-name">José Adrián Noh Chuc</span>
            <span class="ed-footer-meta">DESARROLLADO &mdash; 2026</span>
        </div>
    </div>
</div>