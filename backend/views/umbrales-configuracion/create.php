<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UmbralesConfiguracion $model */

$this->title = 'Create Umbrales Configuracion';
$this->params['breadcrumbs'][] = ['label' => 'Umbrales Configuracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="umbrales-configuracion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
