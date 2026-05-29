<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\AlertasHistorial $model */

$this->title = 'Alerta #' . $model->id_alerta;
$this->params['breadcrumbs'][] = ['label' => 'Historial de alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Configuración visual según nivel de peligro
$niveles = [
    'bajo'     => ['bg' => '#EAF3DE', 'border' => '#97C459', 'text' => '#27500A', 'icon' => 'bi-info-circle'],
    'medio'    => ['bg' => '#FAEEDA', 'border' => '#EF9F27', 'text' => '#633806', 'icon' => 'bi-exclamation-triangle'],
    'alto'     => ['bg' => '#FCEBEB', 'border' => '#F09595', 'text' => '#791F1F', 'icon' => 'bi-exclamation-octagon'],
    'muy alto' => ['bg' => '#FCEBEB', 'border' => '#E24B4A', 'text' => '#501313', 'icon' => 'bi-x-octagon'],
];

$nivelKey = strtolower(trim($model->nivel_peligro ?? 'medio'));
$estilo   = $niveles[$nivelKey] ?? $niveles['medio'];
?>

<div class="alertas-historial-view">

  <!-- Encabezado con título y acciones -->
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-4">
    <div>
      <h1 class="h4 fw-semibold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-bell-fill" style="color: <?= $estilo['text'] ?>; font-size: 18px;"></i>
        <?= Html::encode($this->title) ?>
      </h1>
    </div>
    <div class="d-flex gap-2">
      <?= Html::a(
        '<i class="bi bi-pencil me-1"></i>Editar',
        ['update', 'id_alerta' => $model->id_alerta],
        ['class' => 'btn btn-outline-success btn-sm']
      ) ?>
      <?= Html::a(
        '<i class="bi bi-trash me-1"></i>Eliminar',
        ['delete', 'id_alerta' => $model->id_alerta],
        [
          'class' => 'btn btn-outline-danger btn-sm',
          'data'  => [
            'confirm' => '¿Estás seguro de eliminar esta alerta?',
            'method'  => 'post',
          ],
        ]
      ) ?>
    </div>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; max-width: 580px;">

    <!-- Banner de nivel de peligro (color dinámico) -->
    <div class="d-flex align-items-center gap-3 px-4 py-3"
         style="background: <?= $estilo['bg'] ?>; border-bottom: 0.5px solid <?= $estilo['border'] ?>;">
      <i class="bi <?= $estilo['icon'] ?> fs-5" style="color: <?= $estilo['text'] ?>; flex-shrink:0;"></i>
      <div>
        <div class="fw-semibold" style="font-size: 14px; color: <?= $estilo['text'] ?>;">
          Nivel de peligro: <?= Html::encode($model->nivel_peligro) ?>
        </div>
        <div style="font-size: 11px; color: <?= $estilo['text'] ?>; opacity: 0.75;">
          Dispositivo #<?= Html::encode($model->id_dispositivo) ?>
          &nbsp;·&nbsp; <?= Html::encode($model->fecha_hora) ?>
        </div>
      </div>
    </div>

    <!-- Filas de detalle -->
    <ul class="list-group list-group-flush">

      <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0;">
          <i class="bi bi-hash me-1"></i>ID de alerta
        </span>
        <span class="font-monospace text-muted" style="font-size:12px;">
          <?= Html::encode($model->id_alerta) ?>
        </span>
      </li>

      <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0;">
          <i class="bi bi-cpu me-1"></i>Dispositivo
        </span>
        <span style="font-size:13px;">#<?= Html::encode($model->id_dispositivo) ?></span>
      </li>

      <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0;">
          <i class="bi bi-exclamation-triangle me-1"></i>Nivel de peligro
        </span>
        <span class="badge rounded-pill fw-normal"
              style="background:<?= $estilo['bg'] ?>; color:<?= $estilo['text'] ?>; border: 0.5px solid <?= $estilo['border'] ?>; font-size:11px;">
          <?= Html::encode($model->nivel_peligro) ?>
        </span>
      </li>

      <li class="list-group-item d-flex align-items-start gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0; padding-top:2px;">
          <i class="bi bi-chat-text me-1"></i>Mensaje
        </span>
        <span class="rounded-3 px-3 py-2"
              style="background: var(--bs-light); font-size:13px; line-height:1.6; flex:1;">
          <?= nl2br(Html::encode($model->mensaje_alerta)) ?>
        </span>
      </li>

      <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0;">
          <i class="bi bi-clock-history me-1"></i>Fecha y hora
        </span>
        <span class="text-muted" style="font-size:12px;">
          <?= Html::encode($model->fecha_hora) ?>
        </span>
      </li>

      <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
        <span class="text-muted" style="width:160px; font-size:12px; flex-shrink:0;">
          <i class="bi bi-eye me-1"></i>Leída por usuario
        </span>
        <?php if ($model->leida_por_usuario): ?>
          <span class="badge rounded-pill fw-normal"
                style="background:#EAF3DE; color:#27500A; border:0.5px solid #97C459; font-size:11px;">
            <i class="bi bi-check2 me-1"></i>Leída
          </span>
        <?php else: ?>
          <span class="badge rounded-pill fw-normal"
                style="background:#FAEEDA; color:#633806; border:0.5px solid #EF9F27; font-size:11px;">
            <i class="bi bi-clock me-1"></i>Pendiente
          </span>
        <?php endif; ?>
      </li>

    </ul>
  </div>

</div>