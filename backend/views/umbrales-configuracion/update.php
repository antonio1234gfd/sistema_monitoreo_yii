<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UmbralesConfiguracion $model */

$this->title = 'Update Umbrales Configuracion: ' . $model->id_configuracion;
$this->params['breadcrumbs'][] = ['label' => 'Umbrales Configuracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_configuracion, 'url' => ['view', 'id_configuracion' => $model->id_configuracion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="umbrales-configuracion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
