<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelTest backend\models\Tests */
/* @var $modelsQuestions backend\models\TestQuestion */
/* @var $modelsAnswers backend\models\QuestionAnswer */

$this->title = 'Створити тест';
$this->params['breadcrumbs'][] = ['label' => 'Тести', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelTest' => $modelTest,
        'modelsQuestions' => $modelsQuestions,
        'modelsAnswers' => $modelsAnswers,
    ]) ?>

</div>
