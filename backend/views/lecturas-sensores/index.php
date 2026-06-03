<?php

use common\models\LecturasSensores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\LecturasSensoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lecturas de sensores';
$this->params['breadcrumbs'][] = $this->title;

$total = $dataProvider->getTotalCount();
?>

<style>
  .custom-grid-header th {
    background-color: #f8f9fa !important;
    color: #333333 !important;
    border-bottom: 2px solid #dee2e6 !important;
    font-weight: 600 !important;
    font-size: 13px;
    letter-spacing: 0.3px;
  }

  .custom-grid-header th a {
    color: #495057 !important;
    text-decoration: none !important;
    font-weight: 600 !important;
  }

  .custom-grid-header th a:hover {
    color: #1a1d20 !important;
    text-decoration: underline !important;
  }
</style>

<div class="lecturas-sensores-index">

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h1 class="h4 fw-semibold mb-0">
      <i class="bi bi-activity me-2 text-success"></i>
      <?= Html::encode($this->title) ?>
    </h1>

    <?= Html::a(
      '<i class="bi bi-plus-lg me-1"></i>Nueva lectura',
      ['create'],
      [
        'class' => 'btn btn-sm rounded-pill px-3 fw-bold text-white shadow-sm',
        'style' => 'background-color: #14532d; border-color: #14532d;'
      ]
    ) ?>
  </div>

  <div class="row g-3 mb-4">

    <!-- Tarjeta 1 -->
    <div class="col-6 col-md-3">
      <div class="p-3 bg-white rounded-3 shadow-sm border-start border-primary border-4"
           style="border-left-width: 5px !important;">
        <div class="text-muted small text-uppercase fw-semibold mb-1"
             style="font-size: 10px; letter-spacing: 0.5px;">
          Total lecturas
        </div>

        <div class="fw-bold fs-4 text-dark font-monospace">
          <?= number_format($total) ?>
        </div>
      </div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="col-6 col-md-3">
      <div class="p-3 bg-white rounded-3 shadow-sm border-start border-success border-4"
           style="border-left-width: 5px !important;">
        <div class="text-muted small text-uppercase fw-semibold mb-1"
             style="font-size: 10px; letter-spacing: 0.5px;">
          Dispositivo activo
        </div>

        <div class="fw-bold fs-4 text-dark font-monospace">
          ESP32_Sala
        </div>
      </div>
    </div>

    <!-- Tarjeta 3 -->
    <div class="col-6 col-md-3">
      <div class="p-3 bg-white rounded-3 shadow-sm border-start border-secondary border-4"
           style="border-left-width: 5px !important;">
        <div class="text-muted small text-uppercase fw-semibold mb-1"
             style="font-size: 10px; letter-spacing: 0.5px;">
          Intervalo envío
        </div>

        <div class="fw-bold fs-4 text-dark font-monospace">
          10 seg
        </div>
      </div>
    </div>

    <!-- Tarjeta 4 -->
    <div class="col-6 col-md-3">
      <div class="p-3 bg-white rounded-3 shadow-sm border-start border-warning border-4"
           style="border-left-width: 5px !important; border-color: #fd7e14 !important;">

        <div class="text-muted small text-uppercase fw-semibold mb-1"
             style="font-size: 10px; letter-spacing: 0.5px;">
          Umbrales MQ135
        </div>

        <div class="fw-bold fs-4 text-dark font-monospace">
          <?= $umbrales['mq135_amarillo'] . ' / ' . $umbrales['mq135_rojo'] ?>
          <span class="fs-6 text-muted">ppm</span>
        </div>
      </div>
    </div>

  </div>

  <!-- Tarjeta 5 — Umbral MQ5 -->
<div class="col-6 col-md-3">
  <div class="p-3 bg-white rounded-3 shadow-sm border-start border-danger border-4"
       style="border-left-width: 5px !important;">
    <div class="text-muted small text-uppercase fw-semibold mb-1"
         style="font-size: 10px; letter-spacing: 0.5px;">
      Umbral MQ5 (fuga gas)
    </div>
    <div class="fw-bold fs-4 text-dark font-monospace">
      <?= $umbrales['mq5_fuga'] ?>
      <span class="fs-6 text-muted">ppm</span>
    </div>
  </div>
</div>

  <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">

    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel'  => $searchModel,
      'tableOptions' => [
        'class' => 'table table-striped table-hover align-middle mb-0'
      ],
      'headerRowOptions' => [
        'class' => 'custom-grid-header align-middle'
      ],
      'layout' => "{items}\n{pager}",

      'columns' => [

        ['class' => 'yii\grid\SerialColumn'],

        [
          'attribute' => 'id_lectura',
          'label' => 'ID',
          'headerOptions' => [
            'class' => 'text-white small fw-bold border-0'
          ],
          'contentOptions' => [
            'class' => 'font-monospace text-muted small'
          ],
        ],

        [
          'attribute' => 'id_dispositivo',
          'label' => 'Dispositivo',
          'headerOptions' => [
            'class' => 'text-white small fw-bold border-0'
          ],
          'contentOptions' => [
            'class' => 'font-monospace text-muted small'
          ],
          'value' => fn($m) => '#' . $m->id_dispositivo,
        ],

        // MQ135
        [
          'attribute' => 'mq135_valor',
          'label' => 'MQ135 (ppm)',
          'headerOptions' => [
            'class' => 'text-white small fw-bold border-0'
          ],
          'format' => 'raw',
          'contentOptions' => [
            'class' => 'font-monospace fw-bold'
          ],

          'value' => function ($m) use ($umbrales) {

            $v = (float)$m->mq135_valor;

            if ($v >= $umbrales['mq135_rojo']) {
              $bg = '#dc3545';
              $tc = '#ffffff';
            } elseif ($v >= $umbrales['mq135_amarillo']) {
              $bg = '#d97706';
              $tc = '#ffffff';
            } else {
              $bg = '#198754';
              $tc = '#ffffff';
            }

            return "<span class='badge px-3 py-2 rounded-pill fw-bold text-uppercase'
                    style='background-color:{$bg}; color:{$tc};
                    font-size:11px; letter-spacing:0.5px;'>
                    {$v} ppm
                    </span>";
          },
        ],

        // MQ5
        [
          'attribute' => 'mq5_valor',
          'label' => 'MQ5 (ppm)',
          'headerOptions' => [
            'class' => 'text-white small fw-bold border-0'
          ],
          'format' => 'raw',
          'contentOptions' => [
            'class' => 'font-monospace fw-bold'
          ],

          'value' => function ($m) use ($umbrales) {

            $v = (float)$m->mq5_valor;

            if ($v >= $umbrales['mq5_fuga']) {
              $bg = '#dc3545';
              $tc = '#ffffff';
            } else {
              $bg = '#198754';
              $tc = '#ffffff';
            }

            return "<span class='badge px-3 py-2 rounded-pill fw-bold text-uppercase'
                    style='background-color:{$bg}; color:{$tc};
                    font-size:11px; letter-spacing:0.5px;'>
                    {$v} ppm
                    </span>";
          },
        ],

        // Temperatura — CORREGIDO: null check antes de round()
        [
          'attribute'     => 'dht22_temperatura',
          'label'         => 'Temperatura',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value' => function ($m) {
 
            // Si es null o 0.00 muestra guión
            if ($m->dht22_temperatura === null) {
              return '<span class="text-muted">—</span>';
            }
 
            $t   = round((float)$m->dht22_temperatura, 1);
            $pct = min(100, round(($t / 50) * 100));
            $col = $t >= 35 ? '#E24B4A' : ($t >= 30 ? '#EF9F27' : '#639922');
 
            return "
              <div class='d-flex align-items-center gap-2'>
                <span style='font-size:12px; min-width:52px;'>{$t} °C</span>
                <div style='flex:1; height:4px; border-radius:2px; background:#eee; max-width:60px;'>
                  <div style='width:{$pct}%; height:4px; border-radius:2px; background:{$col};'></div>
                </div>
              </div>
            ";
          },
        ],
 
        // Humedad — CORREGIDO: null check antes de round()
        [
          'attribute'      => 'dht22_humedad',
          'label'          => 'Humedad',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['style' => 'font-size:12px;'],
          'value' => fn($m) => $m->dht22_humedad !== null
            ? round((float)$m->dht22_humedad, 1) . ' %'
            : '—',
        ],
        

        // Fecha
        [
          'attribute' => 'fecha_hora',
          'label' => 'Fecha y hora',
          'headerOptions' => [
            'class' => 'text-white small fw-bold border-0'
          ],
          'contentOptions' => [
            'class' => 'font-monospace text-muted small'
          ],
        ],

        // Acciones
        [
          'class' => ActionColumn::class,
          'header' => '',

          'headerOptions' => [
            'class' => 'border-0'
          ],

          'urlCreator' => fn($action, LecturasSensores $model) =>
            Url::toRoute([
              $action,
              'id_lectura' => $model->id_lectura
            ]),

          'template' => '{view} {update} {delete}',

          'buttons' => [

            'view' => fn($url) =>
              Html::a(
                '<i class="bi bi-eye"></i>',
                $url,
                [
                  'class' =>
                    'btn btn-sm btn-outline-secondary rounded-pill me-1',
                  'title' => 'Ver'
                ]
              ),

            'update' => fn($url) =>
              Html::a(
                '<i class="bi bi-pencil"></i>',
                $url,
                [
                  'class' =>
                    'btn btn-sm btn-outline-success rounded-pill me-1',
                  'title' => 'Editar'
                ]
              ),

            'delete' => fn($url) =>
              Html::a(
                '<i class="bi bi-trash"></i>',
                $url,
                [
                  'class' =>
                    'btn btn-sm btn-outline-danger rounded-pill',
                  'title' => 'Eliminar',
                  'data' => [
                    'confirm' => '¿Eliminar esta lectura?',
                    'method' => 'post'
                  ]
                ]
              ),
          ],
        ],
      ],
    ]); ?>

  </div>

</div>