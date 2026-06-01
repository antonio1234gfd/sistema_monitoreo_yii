<?php
/**
 * ARCHIVO: frontend/views/dashboard/index.php
 */

use yii\helpers\Html;

$this->title = 'Monitor de Calidad del Aire';

$ledColores = [
    'VERDE'    => ['bg' => '#00e676', 'label' => 'NORMAL',      'text' => '#003300'],
    'AMARILLO' => ['bg' => '#ffea00', 'label' => 'ADVERTENCIA', 'text' => '#332200'],
    'ROJO'     => ['bg' => '#ff1744', 'label' => 'CRÍTICO',     'text' => '#330000'],
];

$ledActual    = $estadoActuador ? $estadoActuador->color_led : 'VERDE';
$ledInfo      = $ledColores[$ledActual] ?? $ledColores['VERDE'];
$buzzerActivo = $estadoActuador ? $estadoActuador->buzzer_activo : 0;

$jsonGrafica = json_encode($graficaDatos);
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@400;600;700&display=swap');

  :root {
    --bg:     #0a0e1a;
    --panel:  #111827;
    --border: #1e2d40;
    --accent: #00b4d8;
    --text:   #ccd6f6;
    --muted:  #4a5568;
    --mono:   'Share Tech Mono', monospace;
    --sans:   'Rajdhani', sans-serif;
  }

  body { background: var(--bg); color: var(--text); font-family: var(--sans); }

  .dash-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }

  .dash-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;
  }
  .dash-header h1 {
    font-family: var(--sans); font-weight: 700; font-size: 1.6rem;
    letter-spacing: 3px; text-transform: uppercase; color: var(--accent); margin: 0;
  }
  .dash-header .sub {
    font-family: var(--mono); font-size: 0.72rem;
    color: var(--muted); letter-spacing: 2px; margin-top: 4px;
  }
  .btn-refresh {
    font-family: var(--mono); font-size: 0.8rem; letter-spacing: 2px;
    padding: 0.55rem 1.4rem; border: 1px solid var(--accent);
    background: transparent; color: var(--accent); cursor: pointer;
    transition: all .2s; text-decoration: none; display: inline-block;
  }
  .btn-refresh:hover { background: var(--accent); color: var(--bg); text-decoration: none; }

  .no-device {
    text-align: center; padding: 4rem 2rem;
    font-family: var(--mono); color: var(--muted); border: 1px dashed var(--border);
  }

  .grid-top {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.2rem; margin-bottom: 1.5rem;
  }

  .card {
    background: var(--panel); border: 1px solid var(--border);
    padding: 1.4rem 1.6rem; position: relative; overflow: hidden;
  }
  .card::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 3px; height: 100%; background: var(--accent);
  }
  .card-label {
    font-family: var(--mono); font-size: 0.65rem; letter-spacing: 3px;
    color: var(--muted); text-transform: uppercase; margin-bottom: 0.6rem;
  }
  .card-value {
    font-family: var(--mono); font-size: 2.4rem;
    font-weight: bold; color: #e2e8f0; line-height: 1;
  }
  .card-unit { font-size: 0.9rem; color: var(--muted); margin-left: 4px; }
  .card-ts   { font-family: var(--mono); font-size: 0.62rem; color: var(--muted); margin-top: 0.5rem; }

  /* MQ5 acento naranja */
  .card-mq5::before { background: #ff6b35; }

  .card-led {
    border-color: <?= $ledInfo['bg'] ?>;
    display: flex; flex-direction: column; align-items: flex-start; gap: 0.6rem;
  }
  .card-led::before { background: <?= $ledInfo['bg'] ?>; }

  .led-orb-wrap { display: flex; align-items: center; gap: 1rem; }
  .led-orb {
    width: 52px; height: 52px; border-radius: 50%;
    background: <?= $ledInfo['bg'] ?>;
    box-shadow: 0 0 18px 6px <?= $ledInfo['bg'] ?>88;
    <?php if ($ledActual === 'ROJO'): ?>
    animation: pulse-led 1s ease-in-out infinite;
    <?php endif; ?>
  }
  @keyframes pulse-led {
    0%, 100% { box-shadow: 0 0 18px 6px #ff174488; }
    50%       { box-shadow: 0 0 32px 14px #ff174488; }
  }
  .led-info .led-estado {
    font-family: var(--sans); font-size: 1.4rem; font-weight: 700;
    color: <?= $ledInfo['bg'] ?>; letter-spacing: 2px;
  }
  .led-info .led-buzzer {
    font-family: var(--mono); font-size: 0.7rem;
    letter-spacing: 2px; color: var(--muted); margin-top: 2px;
  }
  .led-info .led-buzzer.on { color: #ff1744; }

  .card-alertas { grid-column: span 2; }
  @media (max-width: 768px) { .card-alertas { grid-column: span 1; } }

  .alerta-item {
    display: flex; align-items: flex-start; gap: 0.8rem;
    padding: 0.6rem 0; border-bottom: 1px solid var(--border);
    font-family: var(--mono); font-size: 0.75rem;
  }
  .alerta-item:last-child { border-bottom: none; }

  .badge {
    padding: 2px 8px; font-size: 0.62rem; letter-spacing: 1.5px;
    font-weight: bold; white-space: nowrap; flex-shrink: 0;
  }
  .badge-critico     { background: #ff174422; color: #ff1744; border: 1px solid #ff174466; }
  .badge-advertencia { background: #ffea0022; color: #ffea00; border: 1px solid #ffea0066; }

  .alerta-msg  { color: var(--text); line-height: 1.4; }
  .alerta-hora { color: var(--muted); font-size: 0.62rem; white-space: nowrap; flex-shrink: 0; margin-left: auto; }
  .no-alertas  { font-family: var(--mono); font-size: 0.75rem; color: var(--muted); padding: 0.5rem 0; }

  .card-chart { margin-top: 1.5rem; padding: 1.6rem; }
  .chart-title {
    font-family: var(--mono); font-size: 0.65rem; letter-spacing: 3px;
    color: var(--muted); text-transform: uppercase; margin-bottom: 1rem;
  }
  canvas { max-height: 260px; }

  .ts-global {
    text-align: right; font-family: var(--mono); font-size: 0.65rem;
    color: var(--muted); margin-top: 1.5rem; letter-spacing: 1.5px;
  }
</style>

<div class="dash-wrap">

  <!-- Header -->
  <div class="dash-header">
    <div>
      <h1>&#9632; Monitor de Calidad del Aire</h1>
      <div class="sub">
        <?php if ($dispositivo): ?>
          DISPOSITIVO: <?= Html::encode($dispositivo->nombre) ?>
          &nbsp;|&nbsp; UBICACIÓN: <?= Html::encode($dispositivo->ubicacion) ?>
          &nbsp;|&nbsp; RED:
          <?= $dispositivo->estado_red
            ? '<span style="color:#00e676">EN LÍNEA</span>'
            : '<span style="color:#ff1744">DESCONECTADO</span>' ?>
        <?php else: ?>
          SIN DISPOSITIVO ASIGNADO
        <?php endif; ?>
      </div>
    </div>
    <?= Html::a('&#8635; ACTUALIZAR', ['dashboard/index'], ['class' => 'btn-refresh']) ?>
  </div>

  <?php if (!$dispositivo): ?>
    <div class="no-device">
      <p>No tienes ningún dispositivo ESP32 registrado.</p>
      <p>Contacta al administrador para que te asigne uno.</p>
    </div>

  <?php else: ?>

    <div class="grid-top">

      <!-- MQ135 -->
<div class="card">

  <div class="card-label">// calidad del aire</div>

  <div class="card-value">
    <?= $ultimaLectura ? number_format($ultimaLectura->mq135_valor, 0) : '---' ?>
    <span class="card-unit">ppm</span>
  </div>

  <!-- AQUI VA -->
  <div class="card-ts">
    Sensor MQ135
  </div>

  <?php if ($ultimaLectura && $ultimaLectura->mq135_valor !== null): ?>

    <?php $ppm = (float)$ultimaLectura->mq135_valor; ?>

    <div class="card-ts">

      <?php if ($ppm < 700): ?>

        <span style="color:#00e676">
          &#9679; Aire limpio
        </span>

      <?php elseif ($ppm < 1000): ?>

        <span style="color:#ffea00">
          &#9679; Aire viciado
        </span>

      <?php else: ?>

        <span style="color:#ff1744">
          &#9679; Contaminación crítica
        </span>

      <?php endif; ?>

    </div>

  <?php endif; ?>

</div>

     <!-- MQ5 -->
<div class="card card-mq5">

  <div class="card-label">// gas lp / metano</div>

  <div class="card-value">
    <?= $ultimaLectura ? number_format($ultimaLectura->mq5_valor ?? 0, 0) : '---' ?>
    <span class="card-unit">ppm</span>
  </div>

  <!-- AQUI VA -->
  <div class="card-ts">
    Sensor MQ5
  </div>

  <?php if ($ultimaLectura && isset($ultimaLectura->mq5_valor)): ?>

    <?php $mq5 = (float)$ultimaLectura->mq5_valor; ?>

    <div class="card-ts">

      <?php if ($mq5 < 120): ?>

        <span style="color:#00e676">
          &#9679; Sin fuga
        </span>

      <?php elseif ($mq5 < 300): ?>

        <span style="color:#ffea00">
          &#9679; Gas moderado
        </span>

      <?php else: ?>

        <span style="color:#ff1744">
          &#9679; FUGA DE GAS
        </span>

      <?php endif; ?>

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
        <div class="card-ts">
          MODO: <?= $estadoActuador ? $estadoActuador->modo_operacion : 'N/A' ?><br>
          <?= $estadoActuador ? date('d/m/Y H:i:s', strtotime($estadoActuador->ultima_actualizacion)) : '' ?>
        </div>
      </div>

      <!-- Alertas -->
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

    </div>

    <!-- Gráfica -->
    <?php if (!empty($graficaDatos)): ?>
    <div class="card card-chart">
      <div class="chart-title">// historial de lecturas (últimas 20)</div>
      <canvas id="chartLecturas"></canvas>
    </div>
    <?php endif; ?>

    <?php if ($ultimaLectura): ?>
    <div class="ts-global">
      ÚLTIMA LECTURA: <?= date('d/m/Y H:i:s', strtotime($ultimaLectura->fecha_hora)) ?>
    </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

<?php if (!empty($graficaDatos)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const datos    = <?= $jsonGrafica ?>;
const labels   = datos.map(d => d.hora);
const mq135Data = datos.map(d => d.mq135);
const mq5Data   = datos.map(d => d.mq5 ?? 0); // ← nuevo
const tempData  = datos.map(d => d.temperatura);
const humData   = datos.map(d => d.humedad);

new Chart(document.getElementById('chartLecturas').getContext('2d'), {
  type: 'line',
  data: {
    labels,
    datasets: [
      {
        label: 'MQ135 (ppm)',
        data: mq135Data,
        borderColor: '#00b4d8', backgroundColor: '#00b4d822',
        borderWidth: 2, pointRadius: 3, tension: 0.3, yAxisID: 'y',
      },
      {
        label: 'MQ5 (ppm)',       // ← nuevo
        data: mq5Data,
        borderColor: '#ff6b35', backgroundColor: '#ff6b3522',
        borderWidth: 2, pointRadius: 3, tension: 0.3, yAxisID: 'y',
      },
      {
        label: 'Temperatura (°C)',
        data: tempData,
        borderColor: '#f72585', backgroundColor: '#f7258522',
        borderWidth: 2, pointRadius: 3, tension: 0.3, yAxisID: 'y1',
      },
      {
        label: 'Humedad (%)',
        data: humData,
        borderColor: '#06d6a0', backgroundColor: '#06d6a022',
        borderWidth: 2, pointRadius: 3, tension: 0.3, yAxisID: 'y1',
      },
    ],
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: {
        labels: { color: '#ccd6f6', font: { family: "'Share Tech Mono', monospace", size: 11 } },
      },
      tooltip: {
        backgroundColor: '#111827', borderColor: '#1e2d40', borderWidth: 1,
        titleColor: '#00b4d8', bodyColor: '#ccd6f6',
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
        type: 'linear', position: 'left',
        title: { display: true, text: 'ppm', color: '#00b4d8', font: { family: "'Share Tech Mono', monospace" } },
        ticks: { color: '#00b4d8', font: { family: "'Share Tech Mono', monospace", size: 10 } },
        grid:  { color: '#1e2d40' },
      },
      y1: {
        type: 'linear', position: 'right',
        title: { display: true, text: '°C / %', color: '#f72585', font: { family: "'Share Tech Mono', monospace" } },
        ticks: { color: '#f72585', font: { family: "'Share Tech Mono', monospace", size: 10 } },
        grid:  { drawOnChartArea: false },
      },
    },
  },
});
</script>
<?php endif; ?>