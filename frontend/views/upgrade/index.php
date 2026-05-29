<?php
/* @var $this yii\web\View */
/* @var $persona frontend\models\Perfil */

use yii\helpers\Html;
?>

<div class="upgrade-index">
    <h1>Hola <?= Html::encode($persona->nombre) ?>, esto requiere un Upgrade</h1>

    <p>
        Puede obtener el acceso que desea realizando un upgrade, pero 
        <strong><?= Html::encode($persona->nombre) ?></strong>, eso no es todo.
        Podrá ir a cualquier lugar, ¿no es eso genial?
    </p>

    <div class="alert alert-info">
        Haga clic en el botón de abajo para mejorar su cuenta a tipo <strong>Pago</strong>.
    </div>
    
    <p>
        <?= Html::a('Realizar Upgrade Ahora', ['pago/proceso'], ['class' => 'btn btn-success']) ?>
    </p>
</div>