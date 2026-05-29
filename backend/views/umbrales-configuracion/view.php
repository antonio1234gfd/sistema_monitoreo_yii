<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UmbralesConfiguracion $model */

$this->title = $model->id_configuracion;
$this->params['breadcrumbs'][] = ['label' => 'Umbrales Configuracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="umbrales-configuracion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_configuracion' => $model->id_configuracion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_configuracion' => $model->id_configuracion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_configuracion',
            'parametro',
            'valor_limite',
            'descripcion',
        ],
    ]) ?>

</div>
