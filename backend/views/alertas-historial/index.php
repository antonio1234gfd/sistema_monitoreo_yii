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

// Estilos por nivel de peligro (badge)
$estiloNivel = [
    'bajo'        => 'background:#EAF3DE; color:#27500A; border:0.5px solid #97C459;',
    'medio'       => 'background:#FAEEDA; color:#633806; border:0.5px solid #EF9F27;',
    'alto'        => 'background:#FCEBEB; color:#791F1F; border:0.5px solid #F09595;',
    'muy alto'    => 'background:#F7C1C1; color:#501313; border:0.5px solid #E24B4A;',
    'advertencia' => 'background:#FAEEDA; color:#633806; border:0.5px solid #EF9F27;',
    'critico'     => 'background:#F7C1C1; color:#501313; border:0.5px solid #E24B4A;',
];
?>

<div class="alertas-historial-index">

  <!-- Encabezado -->
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h1 class="h4 fw-semibold mb-0">
      <i class="bi bi-bell me-2 text-danger"></i>
      <?= Html::encode($this->title) ?>
    </h1>
    <div class="d-flex gap-2">
      <?= Html::a(
        '<i class="bi bi-plus-lg me-1"></i>Nueva alerta',
        ['create'],
        ['class' => 'btn btn-success btn-sm']
      ) ?>
      <?= Html::a(
        '<i class="bi bi-check2-all me-1"></i>Marcar todas como leídas',
        ['marcar-todas-leidas'],
        [
          'class' => 'btn btn-warning btn-sm',
          'data'  => [
            'confirm' => '¿Marcar todas las alertas pendientes como leídas y apagar los buzzers?',
            'method'  => 'post',
          ],
        ]
      ) ?>
    </div>
  </div>

  <!-- Mensajes flash -->
  <?php if (\Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
      <i class="bi bi-check-circle-fill"></i>
      <?= \Yii::$app->session->getFlash('success') ?>
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (\Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
      <i class="bi bi-info-circle-fill"></i>
      <?= \Yii::$app->session->getFlash('info') ?>
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
    'options'      => ['class' => 'card border-0 shadow-sm', 'style' => 'border-radius:16px; overflow:hidden;'],
    'layout'       => "{items}\n{pager}",

    // Colorear filas: rojo si crítico+no leído, amarillo si advertencia+no leído, gris si leído
    'rowOptions' => function ($model) {
      if ($model->leida_por_usuario) {
        return ['style' => 'opacity:0.5; background:#f8f9fa;'];
      }
      $nivel = strtolower(trim($model->nivel_peligro ?? ''));
      if (in_array($nivel, ['critico', 'muy alto', 'alto'])) {
        return ['style' => 'background:#fff5f5;'];
      }
      return ['style' => 'background:#fffbf0;'];
    },

    'columns' => [

      ['class' => 'yii\grid\SerialColumn'],

      // ID
      [
        'attribute'      => 'id_alerta',
        'headerOptions'  => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
      ],

      // Dispositivo
      [
        'attribute'      => 'id_dispositivo',
        'label'          => 'Dispositivo',
        'headerOptions'  => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
        'value'          => fn($m) => '#' . $m->id_dispositivo,
      ],

      // Nivel de peligro con badge de color
      [
        'attribute'     => 'nivel_peligro',
        'label'         => 'Nivel',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'format'        => 'raw',
        'value'         => function ($model) use ($estiloNivel) {
          $key   = strtolower(trim($model->nivel_peligro ?? ''));
          $style = $estiloNivel[$key] ?? $estiloNivel['medio'];
          return '<span class="badge rounded-pill fw-normal" style="' . $style . '; font-size:11px;">'
               . Html::encode($model->nivel_peligro)
               . '</span>';
        },
        'filter' => Html::activeDropDownList(
          $searchModel,
          'nivel_peligro',
          ['ADVERTENCIA' => 'Advertencia', 'CRITICO' => 'Crítico'],
          ['class' => 'form-select form-select-sm', 'prompt' => 'Todos']
        ),
      ],

      // Mensaje truncado
      [
        'attribute'     => 'mensaje_alerta',
        'label'         => 'Mensaje',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'format'        => 'raw',
        'value'         => fn($m) =>
          '<span class="text-muted small" style="display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="' . Html::encode($m->mensaje_alerta) . '">'
          . Html::encode($m->mensaje_alerta)
          . '</span>',
      ],

      // Fecha y hora
      [
        'attribute'      => 'fecha_hora',
        'label'          => 'Fecha y hora',
        'headerOptions'  => ['class' => 'text-muted small fw-normal'],
        'contentOptions' => ['class' => 'font-monospace text-muted small'],
      ],

      // Estado leído / pendiente
      [
        'attribute'     => 'leida_por_usuario',
        'label'         => 'Estado',
        'headerOptions' => ['class' => 'text-muted small fw-normal'],
        'format'        => 'raw',
        'value'         => function ($model) {
          if ($model->leida_por_usuario) {
            return '<span class="badge rounded-pill fw-normal" '
                 . 'style="background:#EAF3DE; color:#27500A; border:0.5px solid #97C459; font-size:11px;">'
                 . '<i class="bi bi-check-lg me-1"></i>Leída</span>';
          }
          return '<span class="badge rounded-pill fw-normal" '
               . 'style="background:#F7C1C1; color:#501313; border:0.5px solid #E24B4A; font-size:11px;">'
               . '<i class="bi bi-exclamation-triangle me-1"></i>Pendiente</span>';
        },
        'filter' => Html::activeDropDownList(
          $searchModel,
          'leida_por_usuario',
          [0 => 'Pendiente', 1 => 'Leída'],
          ['class' => 'form-select form-select-sm', 'prompt' => 'Todos']
        ),
      ],

      // Acciones
      [
        'class'      => ActionColumn::class,
        'header'     => '',
        'urlCreator' => fn($action, AlertasHistorial $model) =>
          Url::toRoute([$action, 'id_alerta' => $model->id_alerta]),
        'template'   => '{view} {update} {delete} {marcar-leida}',
        'buttons'    => [

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

          // Botón marcar como leída — desaparece si ya fue leída
          'marcar-leida' => function ($url, $model) {
            if ($model->leida_por_usuario) {
              // Ya leída: solo un ícono de check sin acción
              return '<span class="btn btn-sm btn-outline-secondary disabled" title="Ya leída" style="opacity:0.4;">'
                   . '<i class="bi bi-bell-slash"></i></span>';
            }
            return Html::a(
              '<i class="bi bi-bell-slash"></i>',
              Url::toRoute(['marcar-leida', 'id_alerta' => $model->id_alerta]),
              [
                'class' => 'btn btn-sm btn-outline-warning',
                'title' => 'Marcar como leída y apagar buzzer',
                'data'  => [
                  'confirm' => '¿Marcar como leída y apagar el buzzer del dispositivo #' . $model->id_dispositivo . '?',
                  'method'  => 'post',
                ],
              ]
            );
          },

        ],
      ],

    ],
  ]); ?>

</div>