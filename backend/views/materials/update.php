<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Materials */

$this->title = 'Оновити матеріали';
$this->params['breadcrumbs'][] = ['label' => 'Матеріали', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Оновити';
?>
<div class="materials-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'testItems'=> $testItems,
        'parents' => $parents
    ]) ?>

</div>
