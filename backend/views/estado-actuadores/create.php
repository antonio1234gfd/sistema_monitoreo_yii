<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EstadoActuadores $model */

$this->title = 'Create Estado Actuadores';
$this->params['breadcrumbs'][] = ['label' => 'Estado Actuadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-actuadores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
