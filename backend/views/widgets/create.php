<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Widgets */

$this->title = 'Create Widgets';
$this->params['breadcrumbs'][] = ['label' => 'Widgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
