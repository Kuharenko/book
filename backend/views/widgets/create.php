<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Widgets */

$this->title = 'Створити віджет';
$this->params['breadcrumbs'][] = ['label' => 'Віджети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
