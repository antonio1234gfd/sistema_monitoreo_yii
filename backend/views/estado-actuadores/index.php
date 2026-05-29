<?php

use common\models\EstadoActuadores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\EstadoActuadoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estado de actuadores';
$this->params['breadcrumbs'][] = $this->title;

$coloresLed = [
    'VERDE'    => ['bg' => '#EAF3DE', 'text' => '#27500A', 'border' => '#97C459', 'dot' => '#3B6D11'],
    'AMARILLO' => ['bg' => '#FAEEDA', 'text' => '#633806', 'border' => '#EF9F27', 'dot' => '#EF9F27'],
    'ROJO'     => ['bg' => '#FCEBEB', 'text' => '#791F1F', 'border' => '#F09595', 'dot' => '#E24B4A'],
];

$modos = [
    'normal'      => ['bg' => '#EAF3DE', 'text' => '#27500A', 'border' => '#97C459'],
    'advertencia' => ['bg' => '#FAEEDA', 'text' => '#633806', 'border' => '#EF9F27'],
    'critico'     => ['bg' => '#FCEBEB', 'text' => '#791F1F', 'border' => '#F09595'],
];
?>

<div class="estado-actuadores-index">

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h1 class="h4 fw-semibold mb-0">
      <i class="bi bi-cpu me-2 text-success"></i>
      <?= Html::encode($this->title) ?>
    </h1>
    <?= Html::a(
      '<i class="bi bi-plus-lg me-1"></i>Nuevo registro',
      ['create'],
      ['class' => 'btn btn-success btn-sm']
    ) ?>
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
          'attribute'      => 'id_dispositivo',
          'label'          => 'Dispositivo',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['class' => 'font-monospace text-muted small'],
          'value'          => fn($m) => '#' . $m->id_dispositivo,
        ],

        // LED RGB con punto de color y badge
        [
          'attribute'     => 'color_led',
          'label'         => 'LED RGB',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) use ($coloresLed) {
            $key   = strtoupper(trim($m->color_led ?? 'VERDE'));
            $c     = $coloresLed[$key] ?? $coloresLed['VERDE'];
            $label = ucfirst(strtolower($key));
            return "<div class='d-flex align-items-center gap-2'>
              <span style='width:12px;height:12px;border-radius:50%;background:{$c['dot']};border:2px solid #fff;box-shadow:0 0 0 1px rgba(0,0,0,0.1);flex-shrink:0;'></span>
              <span class='badge rounded-pill fw-normal' style='background:{$c['bg']};color:{$c['text']};border:0.5px solid {$c['border']};font-size:11px;'>{$label}</span>
            </div>";
          },
        ],

        // Buzzer con ícono y badge
        [
          'attribute'     => 'buzzer_activo',
          'label'         => 'Buzzer',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) {
            if ($m->buzzer_activo) {
              return "<div class='d-flex align-items-center gap-2'>
                <i class='bi bi-volume-up-fill text-danger' style='font-size:14px;'></i>
                <span class='badge rounded-pill fw-normal' style='background:#FCEBEB;color:#791F1F;border:0.5px solid #F09595;font-size:11px;'>Activo</span>
              </div>";
            }
            return "<div class='d-flex align-items-center gap-2'>
              <i class='bi bi-volume-mute text-muted' style='font-size:14px;'></i>
              <span class='badge rounded-pill fw-normal text-muted' style='background:var(--bs-light);border:0.5px solid #ddd;font-size:11px;'>Apagado</span>
            </div>";
          },
          'filter' => Html::activeDropDownList(
            $searchModel, 'buzzer_activo',
            [0 => 'Apagado', 1 => 'Activo'],
            ['class' => 'form-select form-select-sm', 'prompt' => 'Todos']
          ),
        ],

        // Modo de operación con badge de color
        [
          'attribute'     => 'modo_operacion',
          'label'         => 'Modo',
          'headerOptions' => ['class' => 'text-muted small fw-normal'],
          'format'        => 'raw',
          'value'         => function ($m) use ($modos) {
            $key   = strtolower(trim($m->modo_operacion ?? 'normal'));
            $c     = $modos[$key] ?? $modos['normal'];
            $label = ucfirst($key);
            return "<span class='badge rounded-pill fw-normal' style='background:{$c['bg']};color:{$c['text']};border:0.5px solid {$c['border']};font-size:11px;'>{$label}</span>";
          },
        ],

        [
          'attribute'      => 'ultima_actualizacion',
          'label'          => 'Última actualización',
          'headerOptions'  => ['class' => 'text-muted small fw-normal'],
          'contentOptions' => ['class' => 'font-monospace text-muted small'],
        ],

        [
          'class'      => ActionColumn::class,
          'header'     => '',
          'urlCreator' => fn($action, EstadoActuadores $model) =>
            Url::toRoute([$action, 'id_dispositivo' => $model->id_dispositivo]),
          'template'   => '{view} {update} {delete}',
          'buttons'    => [
            'view'   => fn($url) => Html::a('<i class="bi bi-eye"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Ver']),
            'update' => fn($url) => Html::a('<i class="bi bi-pencil"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-success', 'title' => 'Editar']),
            'delete' => fn($url) => Html::a('<i class="bi bi-trash"></i>', $url,
              ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Eliminar',
               'data'  => ['confirm' => '¿Eliminar este registro?', 'method' => 'post']]),
          ],
        ],

      ],
    ]); ?>
  </div>

</div>