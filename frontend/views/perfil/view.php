<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;

/**
 * @var yii\web\View $this
 * @var frontend\models\Perfil $model
 */

$this->title = "Perfil de " . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Iniciales para el avatar
$iniciales = strtoupper(
    substr($model->nombre ?? '?', 0, 1) .
    substr($model->apellido ?? '', 0, 1)
);
?>

<div class="perfil-view">

  <!-- Encabezado con título y acciones -->
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-4">
    <div>
      <h1 class="h4 fw-semibold mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="d-flex gap-2">
      <?php if (PermisosHelpers::userDebeSerPropietario('perfil', $model->id)): ?>
        <?= Html::a(
          '<i class="bi bi-pencil me-1"></i>Editar',
          ['update', 'id' => $model->id],
          ['class' => 'btn btn-outline-success btn-sm']
        ) ?>
      <?php endif; ?>

      <?= Html::a(
        '<i class="bi bi-trash me-1"></i>Eliminar',
        ['delete', 'id' => $model->id],
        [
          'class' => 'btn btn-outline-danger btn-sm',
          'data'  => [
            'confirm' => '¿Estás seguro de eliminar este perfil?',
            'method'  => 'post',
          ],
        ]
      ) ?>
    </div>
  </div>

  <!-- Tarjeta de perfil -->
  <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; max-width: 600px;">

    <!-- Cabecera con avatar e identidad -->
    <div class="card-body d-flex align-items-center gap-3 border-bottom pb-3">
      <div class="d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 fw-semibold text-success fs-5"
           style="width: 56px; height: 56px; flex-shrink: 0;">
        <?= Html::encode($iniciales) ?>
      </div>
      <div>
        <div class="fw-semibold" style="font-size: 16px;">
          <?= Html::encode($model->nombre . ' ' . $model->apellido) ?>
        </div>
        <div class="text-muted small">@<?= Html::encode($model->user->username) ?></div>
      </div>
    </div>

    <!-- Filas de detalle -->
    <?php
    $filas = [
      ['bi bi-person',        'Nombre',            Html::encode($model->nombre)],
      ['bi bi-person',        'Apellido',           Html::encode($model->apellido)],
      ['bi bi-calendar3',     'Fecha de nacimiento', Html::encode($model->fecha_nacimiento)],
      ['bi bi-gender-ambiguous','Género',
        '<span class="badge rounded-pill text-bg-success fw-normal">'
        . Html::encode($model->genero->genero_nombre ?? '—') . '</span>'],
      ['bi bi-clock-history', 'Creado',
        '<span class="text-muted small">' . Html::encode($model->created_at) . '</span>'],
      ['bi bi-clock-history', 'Actualizado',
        '<span class="text-muted small">' . Html::encode($model->updated_at) . '</span>'],
    ];
    ?>

    <ul class="list-group list-group-flush">
      <?php foreach ($filas as [$icono, $label, $valor]): ?>
        <li class="list-group-item d-flex align-items-center gap-3 py-2 px-4">
          <span class="text-muted" style="width: 140px; font-size: 12px; flex-shrink: 0;">
            <i class="bi <?= $icono ?> me-1"></i><?= $label ?>
          </span>
          <span style="font-size: 13px;"><?= $valor ?></span>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>

</div>