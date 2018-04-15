<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\models\Materials */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="https://unpkg.com/clipboard@2.0.0/dist/clipboard.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<script>

    function jsFunctionToBeCalled(editor) {
        editor.addButton('customCode', {
            text: 'Проверка кода',
            icon: false,
            onclick: function () {
                $('#myModalCode').modal('toggle');
                $('#addCode').click(function () {
                    editor.insertContent('<p>[find_error_in_code]</p><pre>'+ $('#codeArea').val()+'</pre><p>[/find_error_in_code]</p>');
                $('#addCode').off( "click" );
                });
            }
        })

        editor.addButton('formatCode', {
            text: 'Форматированый код',
            icon: false,
            onclick: function () {
                $('#myModal').modal('toggle');


                $('.get-code').click(function () {
                    var userCode = $('#unformated-code').val();
                    var formattedUserCode = $('#fm').html(userCode).each(function(i, block) {
                        hljs.highlightBlock(block);
                    });

                    $('#area').text($('#tempEl').html());

                    editor.insertContent($('#area').text());
                    $('.get-code').off('click');

                });
            }
        });

        editor.addButton('animCode', {
            text: 'Анимированый код',
            icon: false,
            onclick: function () {
                $('#myModal').modal('toggle');

                $('.get-code').click(function () {
                    var userCode = $('#unformated-code').val();
                    var formattedUserCode = $('#fm').html(userCode).each(function(i, block) {
                        hljs.highlightBlock(block);
                    });

                    $('#area').text($('#tempEl').html());

                    editor.insertContent('<p>[ts]</p><pre>'+ $('#area').text() +'</pre><p>[/ts]</p>');
                    $('.get-code').off('click');
                });

            }
        })
    }
</script>

<div class="materials-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'clear_html')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | customCode | formatCode | animCode",
            'setup' => new yii\web\JsExpression('jsFunctionToBeCalled'),
        ]
    ]);?>

    <?= $form->field($model, 'announce')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'testId')->dropDownList($testItems, [
        'prompt' => 'Выберите тест'
    ])->label('Выберите тест из существующих тестов или создайте свой')?>

    <div class="form-group">
        <?= Html::a('Создать тест', ['tests/create', 'appendTo'=>$model->id], ['onclick'=> new yii\web\JsExpression("return confirm('Все несохрененные изменения будут утеряны. Хотите продолжить?')")])?>
    </div>

    <div id="area" style="font-size: 0px" ></div>

    <div id="res" style="font-size: 0px"></div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="modal fade" id="myModalCode" tabindex="-1" role="dialog" aria-labelledby="myModalCodeLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalCodeLabel">Додати код</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="codeArea" id="codeArea" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
                    <button type="button" id="addCode" class="btn btn-primary" data-dismiss="modal">Додати код</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Форматировать код
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Форматування коду</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group field-materials-announce required has-success">
                        <label class="control-label" for="unformated-code">Неформатованый код</label>
                        <textarea id="unformated-code" class="form-control" rows="6" aria-required="true" aria-invalid="false">
class classname {
    private:
        // закриті функції та дані
        int somedata;

    public:
        // загальнодоступні функції та дані
        void setdata(int d ) {
            somedata = d;
        }

        void showdata() {
            cout << "Значення поля рівне" << somedata << endl;
        }
};
                        </textarea>

                        <div class="help-block"></div>
                    </div>
                    <div id="tempEl">
         <pre>
            <code class="c++" id="fm"></code>
        </pre>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-primary get-code" data-clipboard-action="cut" data-clipboard-target="#area">Показать и вставить</button>
                </div>
            </div>
        </div>
    </div>

    <script>

                    /*
                   *
                   * 1. Получить код
                   * 2. Отформатировать код скриптом
                   * 3. Занести код в временный блок, для копирования
                   * 4. Скопировать код из блока в буфер
                   *
                   * */

//        new ClipboardJS('.get-code', {
//            container: document.getElementById('myModal'),
//            text: function() {
//                var userCode = $('#unformated-code').val();
//                var formattedUserCode = $('#fm').html(userCode).each(function(i, block) {
//                    hljs.highlightBlock(block);
//                });
//
//                $('#area').text($('#tempEl').html());
//                return $('#area').text();
//            }
//        });

    </script>
</div>
