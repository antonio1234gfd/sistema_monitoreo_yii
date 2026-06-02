<?php
/**
 * ARCHIVO: frontend/views/dashboard/index.php
 * Vista del dashboard de monitoreo de calidad del aire.
 * Solo lectura — visualización de sensores MQ135 + DHT22, LED, alertas y gráficas.
 */

use yii\helpers\Html;

$this->title = 'Monitor de Calidad del Aire';

// Colores del LED según estado
$ledColores = [
    'VERDE'    => ['bg' => '#00e676', 'label' => 'NORMAL',      'text' => '#003300'],
    'AMARILLO' => ['bg' => '#ffea00', 'label' => 'ADVERTENCIA', 'text' => '#332200'],
    'ROJO'     => ['bg' => '#ff1744', 'label' => 'CRÍTICO',     'text' => '#330000'],
];

$ledActual   = $estadoActuador ? $estadoActuador->color_led : 'VERDE';
$ledInfo     = $ledColores[$ledActual] ?? $ledColores['VERDE'];
$buzzerActivo = $estadoActuador ? $estadoActuador->buzzer_activo : 0;

// Datos de gráfica en JSON para Chart.js
$jsonGrafica = json_encode($graficaDatos);
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

  :root {
    --bg:        #f4f7f6; /* Fondo gris muy claro y fresco */
    --panel:     #ffffff; /* Tarjetas blancas */
    --border:    #e2e8f0; /* Bordes muy suaves */
    --accent:    #3b82f6; /* Azul principal amigable */
    --accent-hover: #2563eb;
    --text:      #1e293b; /* Texto oscuro suave (no negro puro) */
    --muted:     #64748b; /* Texto secundario gris */
    --font-main: 'Nunito', sans-serif;
  }

  body { 
    background: var(--bg); 
    color: var(--text); 
    font-family: var(--font-main); 
    margin: 0;
  }

  .dash-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem;
  }

  /* ── Header ── */
  .dash-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px dashed var(--border);
    flex-wrap: wrap;
    gap: 1rem;
  }
  .dash-header h1 {
    font-weight: 800;
    font-size: 1.8rem;
    color: var(--text);
    margin: 0;
  }
  .dash-header .sub {
    font-size: 0.85rem;
    color: var(--muted);
    margin-top: 6px;
    font-weight: 600;
  }
  .dash-header .sub span { font-weight: 700; }

  /* Botón con estilo "Píldora" */
  .btn-refresh {
    font-weight: 700;
    font-size: 0.9rem;
    padding: 0.6rem 1.5rem;
    border-radius: 999px; /* Bordes totalmente redondeados */
    background: #ffffff;
    color: var(--accent);
    border: 2px solid var(--accent);
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.1);
  }
  .btn-refresh:hover {
    background: var(--accent);
    color: #ffffff;
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.2);
    transform: translateY(-2px);
  }
  .btn-refresh:active {
    transform: translateY(0);
  }

  /* ── Sin dispositivo ── */
  .no-device {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--muted);
    background: var(--panel);
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
  }

  /* ── Grid principal ── */
  .grid-top {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  /* ── Panel / Card Amigable ── */
  .card {
    background: var(--panel);
    border-radius: 16px; /* Bordes curvos amigables */
    padding: 1.8rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); /* Sombra muy suave */
    border: 1px solid rgba(0,0,0,0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  }
  .card-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.8rem;
  }
  .card-value {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--accent);
    line-height: 1;
    margin-bottom: 0.5rem;
  }
  .card-unit {
    font-size: 1rem;
    font-weight: 600;
    color: var(--muted);
  }
  .card-ts {
    font-size: 0.8rem;
    color: var(--muted);
    font-weight: 600;
  }

  /* ── Card LED ── */
  .card-led {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
  }
  .led-orb-wrap { display: flex; align-items: center; gap: 1.2rem; }

  .led-orb {
    width: 60px; height: 60px;
    border-radius: 50%;
    background: <?= $ledInfo['bg'] ?>;
    box-shadow: 0 8px 20px <?= $ledInfo['bg'] ?>66, inset 0 -4px 8px rgba(0,0,0,0.1);
    flex-shrink: 0;
    <?php if ($ledActual === 'ROJO'): ?>
    animation: pulse-led 1.5s ease-in-out infinite;
    <?php endif; ?>
  }
  @keyframes pulse-led {
    0%, 100% { box-shadow: 0 8px 20px #ff174466; transform: scale(1); }
    50%      { box-shadow: 0 12px 30px #ff174488; transform: scale(1.05); }
  }

  .led-info .led-estado {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text);
  }
  .led-info .led-buzzer {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--muted);
    margin-top: 4px;
    padding: 2px 8px;
    background: var(--bg);
    border-radius: 8px;
    display: inline-block;
  }
  .led-info .led-buzzer.on { 
    color: #ff1744; 
    background: #ffebee;
  }

  /* ── Alertas ── */
  .card-alertas { 
    grid-column: span 2; 
    max-height: 280px; 
    overflow-y: auto;
    padding-right: 1rem;
  }
  
  /* Scrollbar amigable */
  .card-alertas::-webkit-scrollbar { width: 8px; }
  .card-alertas::-webkit-scrollbar-track { background: var(--bg); border-radius: 10px; }
  .card-alertas::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
  .card-alertas::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  .alerta-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem;
    margin-bottom: 0.5rem;
    background: var(--bg);
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
  }

  .badge {
    padding: 4px 10px;
    font-size: 0.7rem;
    font-weight: 800;
    border-radius: 6px;
    white-space: nowrap;
  }
  .badge-critico     { background: #fee2e2; color: #ef4444; }
  .badge-advertencia { background: #fef9c3; color: #eab308; }

  .alerta-msg  { color: var(--text); flex-grow: 1; }
  .alerta-hora { color: var(--muted); font-size: 0.75rem; white-space: nowrap; }

  .no-alertas {
    font-size: 0.9rem;
    color: var(--muted);
    font-weight: 600;
    padding: 1rem 0;
  }

  /* ── Gráfica ── */
  .card-chart {
    margin-top: 1.5rem;
  }
  .chart-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--muted);
    margin-bottom: 1.5rem;
  }
  canvas { max-height: 300px; width: 100% !important; }

  /* ── Timestamp global ── */
  .ts-global {
    text-align: center;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--muted);
    margin-top: 2rem;
  }

  /* ── Responsive ── */
  @media (max-width: 768px) { 
    .card-alertas { grid-column: span 1; }
    .alerta-item { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .alerta-hora { align-self: flex-end; }
    .dash-header { justify-content: center; text-align: center; }
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
          &nbsp;|&nbsp; RED: <?= $dispositivo->estado_red ? '<span style="color:#00e676">EN LÍNEA</span>' : '<span style="color:#ff1744">DESCONECTADO</span>' ?>
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

    <!-- Fila 1: tarjetas de sensores + LED -->
    <div class="grid-top">

      <!-- MQ135 -->
      <div class="card">
        <div class="card-label">// calidad del aire</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->mq135_valor, 0) : '---' ?>
          <span class="card-unit">ppm</span>
        </div>
        <?php if ($ultimaLectura && $ultimaLectura->mq135_valor !== null): ?>
          <?php $ppm = (float)$ultimaLectura->mq135_valor; ?>
          <div class="card-ts">
            <?php if ($ppm < 700): ?>
              <span style="color:#00e676">&#9679; Aire limpio</span>
            <?php elseif ($ppm < 1000): ?>
              <span style="color:#ffea00">&#9679; Aire viciado</span>
            <?php else: ?>
              <span style="color:#ff1744">&#9679; Contaminación crítica</span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- MQ5 -->
      <div class="card">
        <div class="card-label">// gas combustible</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->mq5_valor, 0) : '---' ?>
          <span class="card-unit">ppm</span>
        </div>
        <div class="card-ts">Sensor MQ5</div>
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

      <!-- Alertas enviadas -->
      <div class="card card-alertas">
        <div class="card-label">// alertas recientes (últimas 5)</div>

        <?php 
        $hayAlertaMQ5 = $ultimaLectura && $ultimaLectura->mq5_valor > 300;
        if (empty($alertas) && !$hayAlertaMQ5): 
        ?>
          <div class="no-alertas">&#10003; Sin alertas registradas</div>
        <?php else: ?>
          <?php if ($hayAlertaMQ5): ?>
            <div class="alerta-item">
              <span class="badge badge-critico">
                CRÍTICO
              </span>
              <span class="alerta-msg">Gas combustible MQ5: <?= number_format($ultimaLectura->mq5_valor, 0) ?> ppm</span>
              <span class="alerta-hora"><?= date('d/m H:i', strtotime($ultimaLectura->fecha_hora)) ?></span>
            </div>
          <?php endif; ?>
          <?php foreach ($alertas as $alerta): ?>
            <div class="alerta-item">
              <span class="badge <?= ($alerta->nivel_peligro === 'CRITICO' || strtolower($alerta->nivel_peligro) === 'muy alto') ? 'badge-critico' : 'badge-advertencia' ?>">
                <?= strtoupper($alerta->nivel_peligro) ?>
              </span>
              <span class="alerta-msg"><?= Html::encode($alerta->mensaje_alerta) ?></span>
              <span class="alerta-hora"><?= date('d/m H:i', strtotime($alerta->fecha_hora)) ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div><!-- /grid-top -->

    <!-- Gráfica de lecturas -->
    <?php if (!empty($graficaDatos)): ?>
    <div class="card card-chart">
      <div class="chart-title">// historial de lecturas (últimas 20)</div>
      <canvas id="chartLecturas"></canvas>
    </div>
    <?php endif; ?>

    <!-- Timestamp última lectura -->
    <?php if ($ultimaLectura): ?>
    <div class="ts-global">
      ÚLTIMA LECTURA: <?= date('d/m/Y H:i:s', strtotime($ultimaLectura->fecha_hora)) ?>
    </div>
    <?php endif; ?>

  <?php endif; ?>

</div><!-- /dash-wrap -->

<?php if (!empty($graficaDatos)): ?>
<!-- Chart.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
fetch('/sistema_monitoreo_yii/frontend/web/index.php?r=sensor/historial&id=1')
  .then(response => response.json())
  .then(json => {
    if (!json.ok) return;
    const datos = json.data;
    const labels      = datos.map(d => {
      const parts = d.fecha_hora.split(' ');
      if (parts.length > 1) {
        const timeParts = parts[1].split(':');
        return timeParts[0] + ':' + timeParts[1];
      }
      return d.fecha_hora;
    });
    const mq135Data   = datos.map(d => d.mq135);
    const mq5Data     = datos.map(d => d.mq5);

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
            label: 'MQ5 (ppm)',
            data: mq5Data,
            borderColor: '#FF6B35',
            backgroundColor: '#FF6B3522',
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
            title: { display: true, text: 'ppm', color: '#FF6B35', font: { family: "'Share Tech Mono', monospace" } },
            ticks: { color: '#FF6B35', font: { family: "'Share Tech Mono', monospace", size: 10 } },
            grid:  { drawOnChartArea: false },
          },
        },
      },
    });
  });
</script>
<?php endif; ?>