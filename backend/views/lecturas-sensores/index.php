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

<div class="lecturas-sensores-index">

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h1 class="h4 fw-semibold mb-0">
      <i class="bi bi-activity me-2 text-success"></i>
      <?= Html::encode($this->title) ?>
    </h1>
    <?= Html::a(
      '<i class="bi bi-plus-lg me-1"></i>Nueva lectura',
      ['create'],
      ['class' => 'btn btn-success btn-sm']
    ) ?>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="p-3 rounded-3" style="background:var(--bs-light);">
        <div class="text-muted small mb-1">Total lecturas</div>
        <div class="fw-semibold fs-5"><?= number_format($total) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="p-3 rounded-3" style="background:var(--bs-light);">
        <div class="text-muted small mb-1">Dispositivo activo</div>
        <div class="fw-semibold fs-5">ESP32_Sala</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="p-3 rounded-3" style="background:var(--bs-light);">
        <div class="text-muted small mb-1">Intervalo envío</div>
        <div class="fw-semibold fs-5">10 seg</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="p-3 rounded-3" style="background:var(--bs-light);">
        <div class="text-muted small mb-1">Umbrales MQ5</div>
        <div class="fw-semibold fs-5">120 / 300 ppm</div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel'  => $searchModel,
      'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
      'layout'       => "{items}\n{pager}",
      'columns' => [

        ['class' => 'yii\grid\SerialColumn'],

        [
          'attribute'      => 'id_lectura',
          'label'          => 'ID',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['class' => 'font-monospace text-muted small'],
        ],

        [
          'attribute'      => 'id_dispositivo',
          'label'          => 'Dispositivo',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['class' => 'font-monospace text-muted small'],
          'value'          => fn($m) => '#' . $m->id_dispositivo,
        ],

        // ── MQ135 ──────────────────────────────────────────
        [
          'attribute'     => 'mq135_valor',
          'label'         => 'MQ135 (ppm)',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) {
            $v = $m->mq135_valor;
            if ($v >= 1000)     [$bg,$tc,$bc] = ['#FCEBEB','#791F1F','#F09595'];
            elseif ($v >= 700)  [$bg,$tc,$bc] = ['#FAEEDA','#633806','#EF9F27'];
            else                [$bg,$tc,$bc] = ['#EAF3DE','#27500A','#97C459'];
            return "<span class='badge rounded-pill fw-normal'
              style='background:{$bg};color:{$tc};border:0.5px solid {$bc};font-size:11px;'>
              {$v} ppm</span>";
          },
        ],

        // ── MQ5 (nuevo) ────────────────────────────────────
        [
          'attribute'     => 'mq5_valor',
          'label'         => 'MQ5 (ppm)',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) {
            $v = $m->mq5_valor ?? 0;
            if ($v >= 300)      [$bg,$tc,$bc] = ['#FCEBEB','#791F1F','#F09595'];
            elseif ($v >= 120)  [$bg,$tc,$bc] = ['#FAEEDA','#633806','#EF9F27'];
            else                [$bg,$tc,$bc] = ['#EAF3DE','#27500A','#97C459'];
            return "<span class='badge rounded-pill fw-normal'
              style='background:{$bg};color:{$tc};border:0.5px solid {$bc};font-size:11px;'>
              {$v} ppm</span>";
          },
        ],

        // ── Temperatura ────────────────────────────────────
        [
          'attribute'     => 'dht22_temperatura',
          'label'         => 'Temperatura',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) {
            $t   = round($m->dht22_temperatura, 1);
            $pct = min(100, round(($t / 50) * 100));
            $col = $t >= 35 ? '#E24B4A' : ($t >= 30 ? '#EF9F27' : '#639922');
            return "<div class='d-flex align-items-center gap-2'>
              <span style='font-size:12px;min-width:52px;'>{$t} °C</span>
              <div style='flex:1;height:4px;border-radius:2px;background:#eee;max-width:60px;'>
                <div style='width:{$pct}%;height:4px;border-radius:2px;background:{$col};'></div>
              </div>
            </div>";
          },
        ],

        // ── Humedad ────────────────────────────────────────
        [
          'attribute'      => 'dht22_humedad',
          'label'          => 'Humedad',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'value'          => fn($m) => round($m->dht22_humedad, 1) . ' %',
          'contentOptions' => ['style' => 'font-size:12px;'],
        ],

        // ── Fecha ──────────────────────────────────────────
        [
          'attribute'      => 'fecha_hora',
          'label'          => 'Fecha y hora',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['class' => 'font-monospace text-muted small'],
        ],

        // ── Acciones ───────────────────────────────────────
        [
          'class'      => ActionColumn::class,
          'header'     => '',
          'urlCreator' => fn($action, LecturasSensores $model) =>
            Url::toRoute([$action, 'id_lectura' => $model->id_lectura]),
          'template'   => '{view} {update} {delete}',
          'buttons'    => [
            'view'   => fn($url) => Html::a('<i class="bi bi-eye"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Ver']),
            'update' => fn($url) => Html::a('<i class="bi bi-pencil"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-success', 'title' => 'Editar']),
            'delete' => fn($url) => Html::a('<i class="bi bi-trash"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Eliminar',
               'data'  => ['confirm' => '¿Eliminar esta lectura?', 'method' => 'post']]),
          ],
        ],

      ],
    ]); ?>
  </div>

</div>