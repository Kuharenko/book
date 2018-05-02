<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Widgets */

$this->title = 'Оновити віджет';
$this->params['breadcrumbs'][] = ['label' => 'Віджети', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Оновити';
?>
<div class="widgets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
