<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Widgets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Віджети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви дісно хочете видалити віджет?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'name',
            'template:ntext',
            'html:ntext',
            'js:ntext',
            'parameters:ntext',
        ],
    ]) ?>

</div>
