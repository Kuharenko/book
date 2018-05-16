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
<script src="//cdn.jsdelivr.net/npm/highlightjs-line-numbers.js@2.3.0/dist/highlightjs-line-numbers.min.js"></script>
<script src="https://unpkg.com/clipboard@2.0.0/dist/clipboard.min.js"></script>
<script>hljs.initHighlightingOnLoad();
    hljs.initLineNumbersOnLoad();</script>

<script>

    function jsFunctionToBeCalled(editor) {
        editor.addButton('customCode', {
            text: 'Перевірка коду',
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
            text: 'Форматований код',
            icon: false,
            onclick: function () {
                $('#myModal').modal('toggle');


                $('.get-code').click(function () {
                    var userCode = $('#unformated-code').val();
                    var formattedUserCode = $('#fm').html(userCode).each(function(i, block) {
                        hljs.lineNumbersBlock(block);
                    });

                    $('#area').text($('#tempEl').html());

                    editor.insertContent($('#area').text());
                    $('.get-code').off('click');

                });
            }
        });

        editor.addButton('animCode', {
            text: 'Анімований код',
            icon: false,
            onclick: function () {
                $('#myModal').modal('toggle');

                $('.get-code').click(function () {
                    var userCode = $('#unformated-code').val();
                    var formattedUserCode = $('#fm').html(userCode).each(function(i, block) {
                        hljs.lineNumbersBlock(block);
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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sortIndex')->textInput() ?>

    <?= $form->field($model, 'parent')->dropDownList($parents)->label('Виберіть батьківську групу')?>

<!--    [
        '0'=>'Без группы',
            '1' => '--- A',
        '5' => '------ Y',
            '2' => '--- B',
        '3' => '------ A',
        '4' => '--------- B',

    ]-->

    <?= $form->field($model, 'announce')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'clear_html')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => 'en',

        'clientOptions' => [
            'relative_urls' => false,
            'remove_script_host' => false,
            'convert_urls' => true,
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste image responsivefilemanager filemanager"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media | customCode | formatCode | animCode",
            'setup' => new yii\web\JsExpression('jsFunctionToBeCalled'),
            'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
            'filemanager_title' => 'Responsive Filemanager',
            'external_plugins' => [
                //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                //Иконка/кнопка загрузки файла в панеле иснструментов.
                'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
            ],
        ]
    ]);?>

    <?= $form->field($model, 'sources')->widget(TinyMce::className(), [
        'options' => ['rows' => 10],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
            'filemanager_title' => 'Responsive Filemanager',
            'external_plugins' => [
                //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                //Иконка/кнопка загрузки файла в панеле иснструментов.
                'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
            ],
        ]
    ]);?>

    <?= $form->field($model, 'testId')->dropDownList($testItems, [
        'prompt' => 'Виберіть тест'
    ])->label('Виберіть тест з існуючих або створіть власній')?>

    <div class="form-group">
        <?= Html::a('Створити тест', ['tests/create', 'appendTo'=>$model->id], ['onclick'=> new yii\web\JsExpression("return confirm('Усі не збережені данні будуть втрачені. Продовжити?')")])?>
    </div>

    <div id="area" style="font-size: 0px" ></div>

    <div id="res" style="font-size: 0px"></div>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
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
                        <label class="control-label" for="unformated-code">Неформатований код</label>
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
                    <button type="button" class="btn btn-primary get-code" data-clipboard-action="cut" data-clipboard-target="#area">Показати та додати</button>
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
