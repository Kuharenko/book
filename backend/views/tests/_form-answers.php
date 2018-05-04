<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $modelsAnswers backend\models\QuestionAnswer */

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-answers',
    'widgetItem' => '.answer-item',
    'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-answer',
    'deleteButton' => '.remove-answer',
    'model' => $modelsAnswers[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'variant',
        'isRight'
    ],
]); ?>
    <div class="container-answers">
<?php foreach ($modelsAnswers as $indexAnswer => $modelAnswer): ?>
    <div class="answer-item panel panel-default"><!-- widgetBody -->
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Варіанти відповідей</h3>
            <div class="pull-right">
                <button type="button" class="add-answer btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i>
                </button>
                <button type="button" class="remove-answer btn btn-danger btn-xs"><i
                            class="glyphicon glyphicon-minus"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <?php
            // necessary for update action.
            if (!$modelAnswer->isNewRecord) {
                echo Html::activeHiddenInput($modelAnswer, "[{$indexTest}][{$indexAnswer}]id");
            }
            ?>
    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($modelAnswer, "[{$indexTest}][{$indexAnswer}]variant")->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4" style="padding-top: 27px">
            <?= $form->field($modelAnswer, "[{$indexTest}][{$indexAnswer}]isRight")->checkbox() ?>
        </div>
    </div>


        </div>
    </div>
<?php endforeach; ?>
    </div>

<?php DynamicFormWidget::end(); ?>