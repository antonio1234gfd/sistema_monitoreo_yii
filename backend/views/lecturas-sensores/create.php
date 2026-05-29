<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LecturasSensores $model */

$this->title = 'Create Lecturas Sensores';
$this->params['breadcrumbs'][] = ['label' => 'Lecturas Sensores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecturas-sensores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
