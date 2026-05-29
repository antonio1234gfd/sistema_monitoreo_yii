<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AlertasHistorial $model */

$this->title = 'Create Alertas Historial';
$this->params['breadcrumbs'][] = ['label' => 'Alertas Historials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-historial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
