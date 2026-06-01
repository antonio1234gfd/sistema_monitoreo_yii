<?php

use yii\helpers\Html;

$this->title = 'Sistema de Monitoreo Atmosférico';
?>

<style>
body{
    background:#0f172a;
}

.hero{
    min-height:80vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:white;
    background:
        linear-gradient(rgba(0,0,0,.75), rgba(0,0,0,.75)),
        url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2000');
    background-size:cover;
    background-position:center;
    border-radius:20px;
    margin-top:20px;
}

.hero-content{
    max-width:900px;
    padding:40px;
}

.hero h1{
    font-size:4rem;
    font-weight:700;
    margin-bottom:20px;
}

.hero p{
    font-size:1.3rem;
    color:#cbd5e1;
    margin-bottom:35px;
}

.btn-monitor{
    background:#0ea5e9;
    color:white;
    padding:15px 40px;
    border-radius:10px;
    text-decoration:none;
    font-size:1.1rem;
    font-weight:bold;
    transition:0.3s;
}

.btn-monitor:hover{
    background:#0284c7;
    color:white;
    text-decoration:none;
}

.features{
    margin-top:60px;
}

.feature-card{
    background:white;
    border-radius:20px;
    padding:30px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
    transition:0.3s;
    height:100%;
}

.feature-card:hover{
    transform:translateY(-8px);
}

.feature-icon{
    font-size:4rem;
    margin-bottom:15px;
}

.feature-title{
    font-size:1.4rem;
    font-weight:bold;
    margin-bottom:10px;
}

.feature-text{
    color:#64748b;
}

.section-title{
    text-align:center;
    margin-bottom:40px;
    font-size:2rem;
    font-weight:bold;
    color:#ffffff;
}

.stats{
    margin-top:60px;
}

.stat-card{
    background:#1e293b;
    color:white;
    border-radius:20px;
    padding:25px;
    text-align:center;
    transition:0.3s;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-number{
    font-size:2rem;
    font-weight:bold;
    color:#38bdf8;
}

.stat-label{
    color:#cbd5e1;
}

.footer-info{
    margin-top:60px;
    text-align:center;
    color:#94a3b8;
    padding-bottom:30px;
}
</style>

<div class="hero">
    <div class="hero-content">

        <h1>🌫️ AirGuard IoT</h1>

        <p>
            Sistema Inteligente de Monitoreo Atmosférico basado en ESP32
            para la detección de contaminantes y gases inflamables mediante
            sensores MQ135 y MQ5.
        </p>

        <?= Html::a(
            'Acceder al Monitor',
            ['/dashboard/index'],
            ['class' => 'btn-monitor']
        ) ?>

    </div>
</div>

<div class="container">

    <h2 class="section-title">
        Tecnologías del Proyecto
    </h2>

    <div class="row features">

        <div class="col-md-4 mb-4">
            <div class="feature-card">

                <div class="feature-icon">
                    🌫️
                </div>

                <div class="feature-title">
                    Sensor MQ135
                </div>

                <div class="feature-text">
                    Monitoreo de calidad del aire y presencia de gases
                    contaminantes en el ambiente.
                </div>

            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-card">

                <div class="feature-icon">
                    🔥
                </div>

                <div class="feature-title">
                    Sensor MQ5
                </div>

                <div class="feature-text">
                    Detección de gases inflamables como GLP, butano,
                    metano y humo.
                </div>

            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-card">

                <div class="feature-icon">
                    🚨
                </div>

                <div class="feature-title">
                    Sistema de Alertas
                </div>

                <div class="feature-text">
                    Activación automática de LED RGB y buzzer cuando
                    se detectan condiciones peligrosas.
                </div>

            </div>
        </div>

    </div>

    <div class="row stats">

        <div class="col-md-4 mb-4">
            <div class="stat-card">
                <div class="stat-number">MQ135</div>
                <div class="stat-label">
                    Calidad del Aire
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="stat-card">
                <div class="stat-number">MQ5</div>
                <div class="stat-label">
                    Detección de Gases
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="stat-card">
                <div class="stat-number">ESP32</div>
                <div class="stat-label">
                    Monitoreo en Tiempo Real
                </div>
            </div>
        </div>

    </div>

    <div class="footer-info">
        Proyecto de Monitoreo Atmosférico • Yii2 • ESP32 • IoT
    </div>

</div>