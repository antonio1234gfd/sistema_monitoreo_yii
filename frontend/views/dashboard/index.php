Dashboard/Index.php

<?php
/**
 * ARCHIVO: frontend/views/dashboard/index.php
 * Vista del dashboard de monitoreo de calidad del aire.
 * Solo lectura — visualización de sensores MQ135 + MQ5, LED, alertas y gráficas.
 */

use yii\helpers\Html;

$this->title = 'Monitor de Calidad del Aire';

// Colores del LED según estado (Ajustados para modo claro)
$ledColores = [
    'VERDE'    => ['bg' => '#10b981', 'label' => 'NORMAL',      'text' => '#ffffff'],
    'AMARILLO' => ['bg' => '#f59e0b', 'label' => 'ADVERTENCIA', 'text' => '#ffffff'],
    'ROJO'     => ['bg' => '#ef4444', 'label' => 'CRÍTICO',     'text' => '#ffffff'],
];

$ledActual    = $estadoActuador ? $estadoActuador->color_led : 'VERDE';
$ledInfo      = $ledColores[$ledActual] ?? $ledColores['VERDE'];
$buzzerActivo = $estadoActuador ? $estadoActuador->buzzer_activo : 0;

// Datos de gráfica en JSON para Chart.js
$jsonGrafica = json_encode($graficaDatos);
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

  :root {
    --bg:        #f8fafc;
    --panel:     #ffffff;
    --border:    #e2e8f0;
    --accent:    #0ea5e9;
    --text:      #334155;
    --muted:     #64748b;
    --success:   #10b981;
    --warning:   #f59e0b;
    --danger:    #ef4444;
    --font-main: 'Inter', system-ui, sans-serif;
  }

  body { background: var(--bg); color: var(--text); font-family: var(--font-main); }

  .dash-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
  }

  /* ── Header ── */
  .dash-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border);
  }
  .dash-header h1 {
    font-weight: 700;
    font-size: 1.6rem;
    color: var(--text);
    margin: 0;
  }
  .dash-header .sub {
    font-size: 0.85rem;
    color: var(--muted);
    margin-top: 6px;
    font-weight: 600;
  }
  .btn-refresh {
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.6rem 1.4rem;
    border-radius: 8px;
    background: var(--accent);
    color: #ffffff;
    text-decoration: none;
    transition: all .2s;
    box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.2);
  }
  .btn-refresh:hover {
    background: #0284c7;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-1px);
  }

  /* ── Grid principal ── */
  .grid-top {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  /* ── Panel / Card ── */
  .card {
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    position: relative;
  }
  .card-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    margin-bottom: 0.8rem;
    letter-spacing: 1px;
  }
  .card-value {
    font-size: 2.8rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
  }
  .card-unit {
    font-size: 1rem;
    color: var(--muted);
    margin-left: 4px;
    font-weight: 400;
  }
  .card-ts {
    font-size: 0.85rem;
    font-weight: 600;
    margin-top: 0.8rem;
  }

  /* ── Card LED ── */
  .card-led {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .led-orb-wrap { display: flex; align-items: center; gap: 1.2rem; }

  .led-orb {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: <?= $ledInfo['bg'] ?>;
    box-shadow: 0 0 15px <?= $ledInfo['bg'] ?>66;
  }

  .led-info .led-estado {
    font-size: 1.2rem;
    font-weight: 700;
    color: <?= $ledInfo['bg'] ?>;
  }
  .led-info .led-buzzer {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--muted);
    margin-top: 4px;
  }
  .led-info .led-buzzer.on { color: var(--danger); }

  /* ── Alertas ── */
  .card-alertas { grid-column: span 2; }
  @media (max-width: 768px) { .card-alertas { grid-column: span 1; } }

  .alerta-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem 0;
    border-bottom: 1px solid var(--border);
    font-size: 0.9rem;
  }
  .alerta-item:last-child { border-bottom: none; }

  .badge {
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 6px;
    white-space: nowrap;
  }
  .badge-critico     { background: #fee2e2; color: var(--danger); }
  .badge-advertencia { background: #fef3c7; color: var(--warning); }

  .alerta-msg  { color: var(--text); font-weight: 500; }
  .alerta-hora { color: var(--muted); font-size: 0.8rem; margin-left: auto; }

  /* ── Gráfica ── */
  .card-chart { padding: 1.5rem; margin-top: 1.5rem; }
  canvas { max-height: 300px; }
</style>

<div class="dash-wrap">

  <div class="dash-header">
    <div>
      <h1>Monitor de Calidad del Aire</h1>
      <div class="sub">
        <?php if ($dispositivo): ?>
          Dispositivo: <?= Html::encode($dispositivo->nombre) ?>
          &nbsp;|&nbsp; Ubicación: <?= Html::encode($dispositivo->ubicacion) ?>
          &nbsp;|&nbsp; Red: <?= $dispositivo->estado_red ? '<span style="color:var(--success)">En línea</span>' : '<span style="color:var(--danger)">Desconectado</span>' ?>
        <?php else: ?>
          Sin dispositivo asignado
        <?php endif; ?>
      </div>
    </div>
    <?= Html::a('Actualizar', ['dashboard/index'], ['class' => 'btn-refresh']) ?>
  </div>

  <?php if ($dispositivo): ?>

    <div class="grid-top">

      <div class="card">
        <div class="card-label">Calidad del Aire (MQ135)</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->mq135_valor, 0) : '---' ?>
          <span class="card-unit">ppm</span>
        </div>
        <?php if ($ultimaLectura && $ultimaLectura->mq135_valor !== null): ?>
          <?php $ppm = (float)$ultimaLectura->mq135_valor; ?>
          <div class="card-ts">
            <?php if ($ppm < $umbrales['mq135_amarillo']): ?>
              <span style="color:var(--success)">&#9679; Aire limpio</span>
            <?php elseif ($ppm < $umbrales['mq135_rojo']): ?>
              <span style="color:var(--warning)">&#9679; Aire viciado</span>
            <?php else: ?>
              <span style="color:var(--danger)">&#9679; Contaminación crítica</span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="card">
        <div class="card-label">Gas Combustible (MQ5)</div>
        <div class="card-value">
          <?= $ultimaLectura ? number_format($ultimaLectura->mq5_valor, 0) : '---' ?>
          <span class="card-unit">ppm</span>
        </div>
        <?php if ($ultimaLectura && $ultimaLectura->mq5_valor !== null): ?>
          <?php $ppm_mq5 = (float)$ultimaLectura->mq5_valor; ?>
          <div class="card-ts">
            <?php if ($ppm_mq5 < $umbrales['mq5_fuga']): ?>
              <span style="color:var(--success)">&#9679; Nivel seguro</span>
            <?php else: ?>
              <span style="color:var(--danger)">&#9679; ¡Fuga detectada!</span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="card card-led">
        <div class="card-label">Estado del Sistema</div>
        <div class="led-orb-wrap">
          <div class="led-orb"></div>
          <div class="led-info">
            <div class="led-estado"><?= $ledActual ?></div>
            <div class="led-buzzer <?= $buzzerActivo ? 'on' : '' ?>">
              Alarma: <?= $buzzerActivo ? 'Activada' : 'Apagada' ?>
            </div>
          </div>
        </div>
        <div class="card-ts" style="color:var(--muted); font-weight:400; font-size:0.75rem;">
          Modo: <?= $estadoActuador ? $estadoActuador->modo_operacion : 'N/A' ?>
        </div>
      </div>

      <div class="card card-alertas">
        <div class="card-label">Alertas Recientes</div>
        
        <?php if (empty($alertas)): ?>
          <div style="color:var(--muted); padding: 1rem 0;">&#10003; Todo está en orden. No hay alertas recientes.</div>
        <?php else: ?>
          <?php foreach ($alertas as $alerta): ?>
            <div class="alerta-item">
              <span class="badge <?= ($alerta->nivel_peligro === 'CRITICO' || strtolower($alerta->nivel_peligro) === 'muy alto') ? 'badge-critico' : 'badge-advertencia' ?>">
                <?= strtoupper($alerta->nivel_peligro) ?>
              </span>
              <span class="alerta-msg"><?= Html::encode($alerta->mensaje_alerta) ?></span>
              <span class="alerta-hora"><?= date('d/m/Y H:i', strtotime($alerta->fecha_hora)) ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>

    <?php if (!empty($graficaDatos)): ?>
    <div class="card card-chart">
      <div class="card-label">Historial de Lecturas</div>
      <canvas id="chartLecturas"></canvas>
    </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

<?php if (!empty($graficaDatos)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
fetch('/sistema_monitoreo_yii/frontend/web/index.php?r=sensor/historial&id=1')
  .then(response => response.json())
  .then(json => {
    if (!json.ok) return;
    const datos = json.data;
    const labels = datos.map(d => {
      const parts = d.fecha_hora.split(' ');
      if (parts.length > 1) {
        const timeParts = parts[1].split(':');
        return timeParts[0] + ':' + timeParts[1];
      }
      return d.fecha_hora;
    });
    const mq135Data = datos.map(d => d.mq135);
    const mq5Data   = datos.map(d => d.mq5);

    const ctx = document.getElementById('chartLecturas').getContext('2d');

    // Ajustes de colores de la gráfica para que combine con el tema claro
    Chart.defaults.color = '#64748b';
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'MQ135 (ppm)',
            data: mq135Data,
            borderColor: '#0ea5e9',
            backgroundColor: 'rgba(14, 165, 233, 0.1)',
            borderWidth: 2,
            pointRadius: 3,
            tension: 0.3,
            fill: true,
            yAxisID: 'y',
          },
          {
            label: 'MQ5 (ppm)',
            data: mq5Data,
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            borderWidth: 2,
            pointRadius: 3,
            tension: 0.3,
            fill: true,
            yAxisID: 'y1',
          },
        ],
      },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            backgroundColor: '#ffffff',
            titleColor: '#334155',
            bodyColor: '#334155',
            borderColor: '#e2e8f0',
            borderWidth: 1,
            padding: 10,
          }
        },
        scales: {
          x: { grid: { display: false } },
          y: { 
            type: 'linear', position: 'left', 
            title: { display: true, text: 'Calidad Aire (ppm)' }
          },
          y1: { 
            type: 'linear', position: 'right', 
            title: { display: true, text: 'Gas (ppm)' },
            grid: { drawOnChartArea: false }
          },
        },
      },
    });
  });
</script>
<?php endif; ?>