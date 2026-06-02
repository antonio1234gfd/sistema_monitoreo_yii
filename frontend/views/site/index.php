<?php

use yii\helpers\Html;

$this->title = 'Sistema de Monitoreo Atmosférico';
?>

<style>
.hero-section{
    min-height:75vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:
        linear-gradient(rgba(15,23,42,.85),rgba(15,23,42,.85)),
        url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2000');
    background-size:cover;
    background-position:center;
    color:white;
    border-radius:15px;
    margin-top:20px;
}

.hero-content{
    text-align:center;
    max-width:900px;
    padding:40px;
}

.hero-title{
    font-size:3.5rem;
    font-weight:700;
    margin-bottom:20px;
}

.hero-subtitle{
    font-size:1.3rem;
    color:#cbd5e1;
    margin-bottom:35px;
}

.btn-monitor{
    background:#0ea5e9;
    color:white;
    padding:15px 35px;
    border-radius:10px;
    text-decoration:none;
    font-size:1.1rem;
    font-weight:600;
    transition:.3s;
}

.btn-monitor:hover{
    background:#0284c7;
    color:white;
    text-decoration:none;
}

.features{
    margin-top:50px;
}

.feature-card{
    background:white;
    border-radius:15px;
    padding:30px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    height:100%;
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-8px);
}

.feature-icon{
    font-size:3rem;
    margin-bottom:15px;
}

.feature-title{
    font-size:1.3rem;
    font-weight:600;
    margin-bottom:10px;
}

.feature-text{
    color:#64748b;
}

.stats{
    margin-top:50px;
}

.stat-card{
    background:#0f172a;
    color:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
}

.stat-number{
    font-size:2rem;
    font-weight:bold;
    color:#38bdf8;
}

.stat-label{
    color:#cbd5e1;
}
</style>

<div class="hero-section">
    <div class="hero-content">

        <h1 class="hero-title">
            Sistema Inteligente de Monitoreo Atmosférico
        </h1>

        <p class="hero-subtitle">
            Plataforma desarrollada con ESP32 para monitorear temperatura,
            humedad y calidad del aire en tiempo real.
        </p>

        <?= Html::a(
            'Ir al Monitor',
            ['/dashboard/index'],
            ['class' => 'btn-monitor']
        ) ?>

    </div>
</div>

<div class="container features">

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">🌡️</div>
                <div class="feature-title">Temperatura</div>
                <div class="feature-text">
                    Monitoreo preciso mediante sensor DHT22.
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">💧</div>
                <div class="feature-title">Humedad</div>
                <div class="feature-text">
                    Visualización de humedad relativa en tiempo real.
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">🌫️</div>
                <div class="feature-title">Calidad del Aire</div>
                <div class="feature-text">
                    Detección de contaminantes mediante MQ135.
                </div>
            </div>
        </div>

    </div>

    <div class="row stats">

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Monitoreo Continuo</div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="stat-number">ESP32</div>
                <div class="stat-label">Procesamiento IoT</div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="stat-number">Tiempo Real</div>
                <div class="stat-label">Actualización Instantánea</div>
            </div>
        </div>

    </div>

</div>