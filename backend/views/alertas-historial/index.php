<?php

use common\models\AlertasHistorial;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\AlertasHistorialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Historial de alertas';
$this->params['breadcrumbs'][] = $this->title;

// Mapa de estilos por nivel de peligro
$estiloNivel = [
    'bajo'     => 'background:#EAF3DE; color:#27500A; border:0.5px solid #97C459;',
    'medio'    => 'background:#FAEEDA; color:#633806; border:0.5px solid #EF9F27;',
    'alto'     => 'background:#FCEBEB; color:#791F1F; border:0.5px solid #F09595;',
    'muy alto' => 'background:#F7C1C1; color:#501313; border:0.5px solid #E24B4A;',
];
?>

<div class="alertas-historial-index">

  <!-- Encabezado -->
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h1 class="h4 fw-semibold mb-0">
      <i class="bi bi-bell me-2 text-danger"></i>
      <?= Html::encode($this->title) ?>
    </h1>
    <?= Html::a(
      '<i class="bi bi-plus-lg me-1"></i>Nueva alerta',
      ['create'],
      ['class' => 'btn btn-success btn-sm']
    ) ?>
  </div>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
    'options'      => ['class' => 'card border-0 shadow-sm', 'style' => 'border-radius:16px; overflow:hidden;'],
    'layout'       => "{items}\n{pager}",
    'columns' => [

      // Número de fila
      ['class' => 'yii\grid\SerialColumn'],

      // ID de alerta
      [
        'attribute' => 'id_alerta',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
      ],

      // Dispositivo
      [
        'attribute' => 'id_dispositivo',
        'label' => 'Dispositivo',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
        'value' => fn($m) => '#' . $m->id_dispositivo,
      ],

      // Nivel de peligro con badge de color dinámico
      [
        'attribute' => 'nivel_peligro',
        'label' => 'Nivel',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'format' => 'raw',
        'value' => function ($model) use ($estiloNivel) {
          $key   = strtolower(trim($model->nivel_peligro ?? ''));
          $style = $estiloNivel[$key] ?? $estiloNivel['medio'];
          return '<span class="badge rounded-pill fw-normal" style="' . $style . '; font-size:11px;">'
               . Html::encode($model->nivel_peligro)
               . '</span>';
        },
        'filter' => Html::activeDropDownList(
          $searchModel,
          'nivel_peligro',
          ['bajo' => 'Bajo', 'medio' => 'Medio', 'alto' => 'Alto', 'muy alto' => 'Muy alto'],
          ['class' => 'form-select form-select-sm', 'prompt' => 'Todos']
        ),
      ],

      // Mensaje truncado
      [
        'attribute' => 'mensaje_alerta',
        'label' => 'Mensaje',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'format' => 'raw',
        'value' => fn($m) => '<span class="text-muted small" style="display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="' . Html::encode($m->mensaje_alerta) . '">'
                           . Html::encode($m->mensaje_alerta)
                           . '</span>',
      ],

      // Fecha y hora
      [
        'attribute' => 'fecha_hora',
        'label' => 'Fecha y hora',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
      ],

      // Acciones con iconos
      [
        'class' => ActionColumn::class,
        'header' => '',
        'urlCreator' => fn($action, AlertasHistorial $model) =>
          Url::toRoute([$action, 'id_alerta' => $model->id_alerta]),
        'template' => '{view} {update} {delete}',
        'buttons' => [
          'view' => fn($url) => Html::a(
            '<i class="bi bi-eye"></i>',
            $url,
            ['class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Ver']
          ),
          'update' => fn($url) => Html::a(
            '<i class="bi bi-pencil"></i>',
            $url,
            ['class' => 'btn btn-sm btn-outline-success', 'title' => 'Editar']
          ),
          'delete' => fn($url) => Html::a(
            '<i class="bi bi-trash"></i>',
            $url,
            [
              'class' => 'btn btn-sm btn-outline-danger',
              'title' => 'Eliminar',
              'data'  => ['confirm' => '¿Eliminar esta alerta?', 'method' => 'post'],
            ]
          ),
        ],
      ],

    ],
  ]); ?>

</div>