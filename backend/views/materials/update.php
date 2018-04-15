<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Materials */

$this->title = 'Update Materials: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="materials-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'testItems'=> $testItems
    ]) ?>

</div>
