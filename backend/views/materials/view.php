<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Materials */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Матеріали', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materials-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви дійсно хочете видалити матеріал?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'clear_html:ntext',
//            'content:ntext',
            'post_scripts:ntext',
            'announce:ntext',
        ],
    ]) ?>

</div>
