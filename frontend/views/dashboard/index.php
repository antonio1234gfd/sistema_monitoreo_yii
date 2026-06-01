<?php
/**
 * ARCHIVO: frontend/views/dashboard/index.php
 * Vista del dashboard de monitoreo de calidad del aire.
 * Nivel Superior V2 - DISEÑO DE ALTO IMPACTO (SCI-FI HUD)
 */

use yii\helpers\Html;

$this->title = 'SISTEMA DE MONITOREO ATMOSFÉRICO v2.1';

// Configuración de Paleta de Colores Dinámica (Neón saturado)
$ppmValor = $ultimaLectura ? (float)$ultimaLectura->mq135_valor : 0;
$estadoColor = '#00f2fe'; // Por defecto (Limpio)
$estadoTexto = 'ESTABLE';
$nivelInsignia = 'badge-insignia-buena';

if ($ppmValor >= 1000) {
    $estadoColor = '#ff0055'; // Crítico
    $estadoTexto = 'PELIGRO - CRÍTICO';
    $nivelInsignia = 'badge-insignia-critica';
} elseif ($ppmValor >= 700) {
    $estadoColor = '#f5af19'; // Advertencia
    $estadoTexto = 'PRECAUCIÓN - VICIADO';
    $nivelInsignia = 'badge-insignia-advertencia';
}

$buzzerActivo = $estadoActuador ? $estadoActuador->buzzer_activo : 0;
$ledActual = $estadoActuador ? $estadoActuador->color_led : 'VERDE';

// Datos de gráfica en JSON
$jsonGrafica = json_encode($graficaDatos);
?>

<style>
  /* Importación de fuentes para impacto visual */
  @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Share+Tech+Mono&display=swap');

  :root {
    --bg-dark:       #010204;
    --terminal-black:#0a0c10;
    /* Colores Neón Principal Dinámico */
    --u-accent:      <?= $estadoColor ?>;
    --u-accent-rgb:  <?= hexToRgb($estadoColor) ?>; /* Función auxiliar abajo */
    
    --text-primary:  #e0e6ed;
    --text-muted:     #6c757d;
    --glass-border:  rgba(255, 255, 255, 0.04);
    
    /* Fuentes */
    --f-sci-fi:      'Orbitron', sans-serif;
    --f-mono:        'Share Tech Mono', monospace;
  }

  body { 
    background-color: var(--bg-dark);
    /* Fondo técnico sutil */
    background-image: 
        linear-gradient(rgba(var(--u-accent-rgb), 0.03) 1px, transparent 1px),
        linear-gradient(90px, rgba(var(--u-accent-rgb), 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    color: var(--text-primary); 
    font-family: var(--f-mono);
    min-height: 100vh;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
  }

  /* Efecto de escaneo de líneas (CRT) sutil en toda la pantalla */
  body::before {
    content: " ";
    display: block;
    position: fixed;
    top: 0; left: 0; bottom: 0; right: 0;
    background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
    background-size: 100% 4px;
    z-index: 9999;
    pointer-events: none;
    opacity: 0.3;
  }

  .hud-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem;
    position: relative;
    animation: hudOpening 1s ease-out forwards;
  }

  /* ── Header Ultra-Tecnológico ── */
  .hud-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem;
    background: rgba(10, 12, 16, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    border-top: 2px solid var(--u-accent);
    margin-bottom: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.5);
  }
  .hud-title-zone h1 {
    font-family: var(--f-sci-fi);
    font-weight: 700;
    font-size: 1.6rem;
    letter-spacing: 3px;
    color: #fff;
    text-transform: uppercase;
    text-shadow: 0 0 10px rgba(var(--u-accent-rgb), 0.7);
    margin: 0;
  }
  .hud-title-zone .status-insignia {
    font-family: var(--f-sci-fi);
    font-size: 0.8rem;
    letter-spacing: 2px;
    color: var(--u-accent);
    margin-top: 5px;
  }
  .hud-title-zone .status-insignia::before {
      content: ''; display: inline-block; width: 10px; height: 10px;
      border-radius: 50%; background: var(--u-accent); margin-right: 8px;
      box-shadow: 0 0 10px var(--u-accent);
  }

  .hud-meta-zone { text-align: right; font-size: 0.8rem; color: var(--text-muted); }
  .hud-meta-zone strong { color: var(--text-primary); }

  .btn-sys-refresh {
    font-family: var(--f-sci-fi); font-size: 0.8rem; letter-spacing: 2px;
    padding: 0.7rem 1.8rem;
    border: 2px solid var(--u-accent);
    background: transparent; color: var(--u-accent);
    text-decoration: none; border-radius: 0; cursor: pointer;
    transition: all 0.2s ease;
    clip-path: polygon(15% 0, 100% 0, 85% 100%, 0% 100%); /* Forma biselada */
  }
  .btn-sys-refresh:hover {
    background: var(--u-accent); color: var(--bg-dark);
    box-shadow: 0 0 25px rgba(var(--u-accent-rgb), 0.6);
  }

  /* ── Layout Principal ── */
  .hud-grid {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    grid-template-rows: auto auto;
    gap: 1.5rem;
  }
  @media (max-width: 1100px) { .hud-grid { grid-template-columns: 1fr 1fr; } }
  @media (max-width: 768px) { .hud-grid { grid-template-columns: 1fr; } }

  /* ── Estilo de Paneles Glass ── */
  .hud-panel {
    background: rgba(var(--terminal-black), 0.8);
    backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-radius: 4px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    position: relative;
    transition: all 0.3s ease;
    opacity: 0; animation: panelFadeIn 0.5s ease-out forwards;
  }
  .hud-panel:hover { border-color: rgba(var(--u-accent-rgb), 0.2); }
  
  /* Retrasos de animación para efecto cascada */
  .col-side-left .hud-panel:nth-child(1) { animation-delay: 0.2s; }
  .col-side-left .hud-panel:nth-child(2) { animation-delay: 0.3s; }
  .col-main-hero { animation-delay: 0.1s; }
  .col-side-right .hud-panel:nth-child(1) { animation-delay: 0.4s; }
  .full-width-panel { animation-delay: 0.5s; }

  .panel-header {
    font-family: var(--f-sci-fi); font-size: 0.9rem; font-weight: 600;
    color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;
    margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between;
    padding-bottom: 8px; border-bottom: 1px solid rgba(255,255,255,0.05);
  }

  /* ── UNIDAD CENTRAL HERO (MQ135) ── */
  .col-main-hero {
    grid-column: 2; grid-row: 1;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    border: 2px solid rgba(var(--u-accent-rgb), 0.2);
    box-shadow: 0 0 50px rgba(var(--u-accent-rgb), 0.2);
  }
  
  .hero-label {
    font-family: var(--f-sci-fi); font-size: 1.1rem; color: var(--text-primary);
    letter-spacing: 4px; text-transform: uppercase; margin-bottom: 1rem;
    text-shadow: 0 0 10px rgba(var(--u-accent-rgb), 0.6);
  }

  .ppm-circle-wrap {
    position: relative;
    width: 280px; height: 280px;
    display: flex; align-items: center; justify-content: center;
  }
  /* Anillo giratorio de estatus */
  .ppm-circle-wrap::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    border-radius: 50%;
    border: 4px solid rgba(var(--u-accent-rgb), 0.1);
    border-top-color: var(--u-accent);
    animation: spin 3s linear infinite;
    box-shadow: 0 0 30px rgba(var(--u-accent-rgb), 0.3);
  }

  .ppm-value {
    font-family: var(--f-mono); font-size: 6.5rem; font-weight: 700;
    color: #fff; line-height: 1; margin: 0;
    text-shadow: 0 0 30px var(--u-accent), 0 0 60px var(--u-accent);
  }
  .ppm-unit {
    font-family: var(--f-sci-fi); font-size: 1.2rem; color: var(--u-accent);
    letter-spacing: 2px; text-transform: uppercase; position: absolute; bottom: 60px;
  }
  
  .status-detailed {
      font-family: var(--f-sci-fi); font-size: 1.2rem; color: var(--u-accent);
      letter-spacing: 2px; font-weight: 700; text-transform: uppercase;
      margin-top: 1.5rem; background: rgba(var(--u-accent-rgb), 0.1);
      padding: 8px 25px; border-radius: 4px;
  }

  /* ── Columnas Laterales (DHT22) ── */
  .side-value {
    font-family: var(--f-mono); font-size: 3.5rem; font-weight: bold;
    color: #fff; line-height: 1; margin-top: 0.5rem;
  }
  .side-unit { font-size: 1.4rem; font-weight: 400; vertical-align: super;}
  .side-desc { color: var(--text-muted); font-size: 0.85rem; margin-top: 8px; letter-spacing: 1px;}
  
  /* Detalles visuales en tarjetas laterales */
  .temp-hl { --side-accent: #ff9f43; color: var(--side-accent) !important; }
  .hum-hl { --side-accent: #54a0ff; color: var(--side-accent) !important; }

  /* ── Panel LED (Look 3D mejorado) ── */
  .col-side-right { display: flex; flex-direction: column; gap: 1.5rem;}
  .led-panel-content { display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem;}
  .sys-led-orb {
    width: 65px; height: 65px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.1);
    background: radial-gradient(circle at 35% 35%, #fff 0%, #aaa 10%, #000 100%); /* Look apagado */
    position: relative; transition: all 0.3s;
  }
  /* Estilos de LED encendido basados en el color */
  <?php if ($ledActual === 'VERDE'): ?>
  .sys-led-orb { background: radial-gradient(circle at 35% 35%, #fff 0%, #39ff14 40%, #004d00 100%); box-shadow: 0 0 25px #39ff14, inset 0 0 10px rgba(255,255,255,0.5); }
  <?php elseif ($ledActual === 'AMARILLO'): ?>
  .sys-led-orb { background: radial-gradient(circle at 35% 35%, #fff 0%, #ffea00 40%, #4d4600 100%); box-shadow: 0 0 25px #ffea00, inset 0 0 10px rgba(255,255,255,0.5); }
  <?php elseif ($ledActual === 'ROJO'): ?>
  .sys-led-orb { background: radial-gradient(circle at 35% 35%, #fff 0%, #ff1744 40%, #4d0010 100%); box-shadow: 0 0 35px #ff1744, inset 0 0 10px rgba(255,255,255,0.5); animation: alertPulse 1.5s infinite; }
  <?php endif; ?>

  .sys-text-data { font-family: var(--f-sci-fi); }
  .sys-led-label { color: #fff; font-size: 1.3rem; letter-spacing: 1px; font-weight: 700; }
  .sys-buzzer {
      margin-top: 4px; font-size: 0.8rem; letter-spacing: 1px; padding: 2px 6px; border-radius: 2px; display: inline-block;
      <?= $buzzerActivo ? 'background:#ff1744; color:#fff; font-weight:700;' : 'background:rgba(255,255,255,0.05); color:var(--text-muted);' ?>
  }

  /* ── Panel de Alertas (Estilo Terminal) ── */
  .full-width-panel { grid-column: 1 / -1; border-color: rgba(255, 23, 68, 0.15); }
  .alert-log-window {
    max-height: 200px; overflow-y: auto;
    font-family: var(--f-mono); font-size: 0.85rem;
    padding-right: 10px;
  }
  .alert-entry {
    display: grid; grid-template-columns: 140px 100px 1fr;
    gap: 15px; padding: 6px 0;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    transition: background 0.1s;
  }
  .alert-entry:hover { background: rgba(255,255,255,0.01); }
  .a-time { color: var(--text-muted); }
  .a-level { font-weight: bold; text-transform: uppercase; text-align: center;}
  .a-msg { color: var(--text-primary); }

  .lvl-critico { color: #ff1744; text-shadow: 0 0 5px #ff1744; }
  .lvl-advertencia { color: #ffea00; text-shadow: 0 0 5px #ffea00; }
  
  .scroll-styled::-webkit-scrollbar { width: 5px; }
  .scroll-styled::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
  .scroll-styled::-webkit-scrollbar-thumb { background: rgba(var(--u-accent-rgb), 0.2); border-radius: 2px; }

  /* ── Gráfica Premium HUD ── */
  canvas#chartHud { width: 100% !important; max-height: 380px; }

  /* ── Animaciones Base ── */
  @keyframes spin { 100% { transform: rotate(360deg); } }
  @keyframes alertPulse { 0%, 100% { box-shadow: 0 0 35px #ff1744; opacity: 1; } 50% { box-shadow: 0 0 60px #ff1744; opacity: 0.8; } }
  
  @keyframes hudOpening {
      from { opacity: 0; transform: scale(1.05); filter: blur(5px); }
      to { opacity: 1; transform: scale(1); filter: blur(0); }
  }
  @keyframes panelFadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
  }
</style>

<div class="hud-wrap">

  <header class="hud-header">
    <div class="hud-title-zone">
      <h1><?= Html::encode($this->title) ?></h1>
      <div class="status-insignia">ESTADO DE RED: <?= $dispositivo && $dispositivo->estado_red ? 'EN LÍNEA' : '<span style="color:#ff1744">FUERA DE LÍNEA</span>' ?></div>
    </div>
    
    <div class="hud-meta-zone">
        <?php if ($dispositivo): ?>
            <div>NODO ID: <strong><?= Html::encode($dispositivo->nombre) ?></strong></div>
            <div>UBICACIÓN: <strong><?= Html::encode($dispositivo->ubicacion) ?></strong></div>
        <?php endif; ?>
        <div style="margin-top:10px;">
             <?= Html::a('[ RESCANEAR SISTEMA ]', ['dashboard/index'], ['class' => 'btn-sys-refresh']) ?>
        </div>
    </div>
  </header>

  <?php if ($dispositivo): ?>

    <div class="hud-grid">
    
      <aside class="col-side-left">
        <div class="hud-panel">
          <div class="panel-header temp-hl">
              <span>// TEMPERATURA</span>
              <span class="hud-icon">&#127777;</span>
          </div>
          <div class="side-value temp-hl">
            <?= $ultimaLectura ? number_format($ultimaLectura->dht22_temperatura, 1) : '---' ?><span class="side-unit">°C</span>
          </div>
          <div class="side-desc">CORE SENSOR: DHT22</div>
        </div>
        
        <div class="hud-panel">
          <div class="panel-header hum-hl">
              <span>// HUMEDAD</span>
              <span class="hud-icon">&#128167;</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Temperatura -->
      <div class="card">
        <div class="card-label">// temperatura</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->dht22_temperatura, 1) : '---' ?>
          <span class="card-unit">°C</span>
        </div>
        <div class="card-ts">Sensor DHT22</div>
      </div>

      <!-- Humedad -->
      <div class="card">
        <div class="card-label">// humedad relativa</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->dht22_humedad, 1) : '---' ?>
          <span class="card-unit">%</span>
        </div>
        <div class="card-ts">Sensor DHT22</div>
      </div>

      <!-- Estado LED + Buzzer -->
      <div class="card card-led">
        <div class="card-label">// estado del sistema</div>
        <div class="led-orb-wrap">
          <div class="led-orb"></div>
          <div class="led-info">
            <div class="led-estado"><?= $ledActual ?></div>
            <div class="led-buzzer <?= $buzzerActivo ? 'on' : '' ?>">
              BUZZER: <?= $buzzerActivo ? '&#128266; ACTIVO' : 'APAGADO' ?>
            </div>
          </div>
        </div>
        
        <div class="hud-panel">
            <div class="panel-header"><span>// SYS MODE</span></div>
            <div style="font-family:var(--f-sci-fi); font-size:1.8rem; color:#fff; font-weight:700; text-transform:uppercase;">
                <?= $estadoActuador ? $estadoActuador->modo_operacion : 'N/A' ?>
            </div>
        </div>
      </div>

      <!-- Alertas enviadas -->
      <div class="card card-alertas">
        <div class="card-label">// alertas recientes (últimas 5)</div>

        <?php if (empty($alertas)): ?>
          <div class="no-alertas">&#10003; Sin alertas registradas</div>
        <?php else: ?>
          <?php foreach ($alertas as $alerta): ?>
            <div class="alerta-item">
              <span class="badge <?= $alerta->nivel_peligro === 'CRITICO' ? 'badge-critico' : 'badge-advertencia' ?>">
                <?= $alerta->nivel_peligro ?>
              </span>
              <span class="alerta-msg"><?= Html::encode($alerta->mensaje_alerta) ?></span>
              <span class="alerta-hora"><?= date('d/m H:i', strtotime($alerta->fecha_hora)) ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div><!-- /grid-top -->

      <?php if (!empty($graficaDatos)): ?>
      <section class="hud-panel full-width-panel">
        <div class="panel-header"><span>// ANALYTICAL DATA HISTORY (20 CYCLES)</span></div>
        <div class="chart-container" style="position:relative; height:40vh;">
            <canvas id="chartHud"></canvas>
        </div>
      </section>
      <?php endif; ?>

    </div>

  <?php else: ?>
    <div class="hud-panel" style="text-align:center; padding: 5rem 2rem; border-color:#ff1744; animation: alertPulse 2s infinite;">
        <h2 style="font-family:var(--f-sci-fi); color:#ff1744;">ERROR: DISPOSITIVO NO ASIGNADO</h2>
        <p style="font-family:var(--f-mono); color:var(--text-muted);">Por favor, contacte al administrador de sistemas para vincular un nodo ESP32.</p>
    </div>
  <?php endif; ?>

</div>

<?php
// Función para convertir Hexadecimal a RGB (necesaria para transparencias dinámicas en CSS)
function hexToRgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}
?>

<?php if (!empty($graficaDatos)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const datos = <?= $jsonGrafica ?>;
const labels      = datos.map(d => d.hora);
const mq135Data   = datos.map(d => d.mq135);
const tempData    = datos.map(d => d.temperatura);
const humData     = datos.map(d => d.humedad);

const ctx = document.getElementById('chartLecturas').getContext('2d');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'MQ135 (ppm)',
        data: mq135Data,
        borderColor: '#00b4d8',
        backgroundColor: '#00b4d822',
        borderWidth: 2,
        pointRadius: 3,
        tension: 0.3,
        yAxisID: 'y',
      },
      {
        label: 'Temperatura (°C)',
        data: tempData,
        borderColor: '#ff6b35',
        backgroundColor: '#ff6b3522',
        borderWidth: 2,
        pointRadius: 3,
        tension: 0.3,
        yAxisID: 'y1',
      },
      {
        label: 'Humedad (%)',
        data: humData,
        borderColor: '#06d6a0',
        backgroundColor: '#06d6a022',
        borderWidth: 2,
        pointRadius: 3,
        tension: 0.3,
        yAxisID: 'y1',
      },
    ],
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: {
        labels: {
          color: '#ccd6f6',
          font: { family: "'Share Tech Mono', monospace", size: 11 },
        },
      },
      tooltip: {
        backgroundColor: '#111827',
        borderColor: '#1e2d40',
        borderWidth: 1,
        titleColor: '#00b4d8',
        bodyColor: '#ccd6f6',
        titleFont: { family: "'Share Tech Mono', monospace" },
        bodyFont:  { family: "'Share Tech Mono', monospace" },
      },
    },
    scales: {
      x: {
        ticks: { color: '#4a5568', font: { family: "'Share Tech Mono', monospace", size: 10 } },
        grid:  { color: '#1e2d40' },
      },
      y: {
        type: 'linear',
        position: 'left',
        title: { display: true, text: 'ppm', color: '#00b4d8', font: { family: "'Share Tech Mono', monospace" } },
        ticks: { color: '#00b4d8', font: { family: "'Share Tech Mono', monospace", size: 10 } },
        grid:  { color: '#1e2d40' },
      },
      y1: {
        type: 'linear',
        position: 'right',
        title: { display: true, text: '°C / %', color: '#ff6b35', font: { family: "'Share Tech Mono', monospace" } },
        ticks: { color: '#ff6b35', font: { family: "'Share Tech Mono', monospace", size: 10 } },
        grid:  { drawOnChartArea: false },
      },
    },
  },
});
</script>
<?php endif; ?>