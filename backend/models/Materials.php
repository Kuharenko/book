<?php

namespace backend\models;

use backend\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $post_scripts
 * @property string $announce
 * @property string $clear_html
 * @property int $testId
 * @property string $sources
 *
 * @property MaterialCategories[] $materialCategories
 * @property MaterialTask[] $materialTasks
 * @property Progress[] $progresses
 */
class Materials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    public  function extraFields()
    {

        return [
            'categories',
            'tests',
            'progress'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'post_scripts', 'announce', 'clear_html', 'sources'], 'string'],
            [['name','announce', 'clear_html'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['testId', 'parent', 'sortIndex'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва',
            'content' => 'Форматований зміст',
            'post_scripts' => 'Скрипти',
            'announce' => 'Короткий зміст',
            'clear_html' => 'Зміст',
            'testId' => 'ID тесту',
            'parent' => 'Батьківска група',
            'sortIndex' => 'Індекс сортування',
            'sources' => 'Джерела'
        ];
    }
    /* Получаем категории из связующей таблицы */
//    public function getCategories()
//    {
//        return $this->hasMany(Category::className(), ['id' => 'category_id'])
//            ->viaTable('material_categories', ['material_id' => 'id'])->asArray();
//    }

    public function getProgress()
    {
        if(Yii::$app->request->get('access-token')){
            $user = User::findIdentityByAccessToken(Yii::$app->request->get('access-token'));
            if($user){
                return $this->hasOne(Progress::className(), ['material_id' => 'id'])->where(['user_id'=>$user->id]);
            }
        }
        return $this->hasOne(Progress::className(), ['material_id' => 'id']);
    }

    public function getTests()
    {
        $array  = [];
        $tests = Tests::findOne($this->testId);
        if(!is_null($tests)) {
            $array['id'] = $tests->id;
            $array['test_name'] = $tests->question;

            foreach ($tests->testQuestions as $index => $question) {
                $array['test_questions'][$index]['id'] = $question->id;
                $array['test_questions'][$index]['question'] = $question->question;

                foreach ($question->questionAnswers as $answer_index => $answer) {
                    $array['test_questions'][$index]['answers'][$answer_index]['id'] = $answer->id;
                    $array['test_questions'][$index]['answers'][$answer_index]['variant'] = $answer->variant;
                    $array['test_questions'][$index]['answers'][$answer_index]['isRight'] = $answer->isRight;
                }
            }
            return $array;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialCategories()
    {
        return $this->hasMany(MaterialCategories::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Tests::className(), ['id' => 'testId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialTasks()
    {
        return $this->hasMany(MaterialTask::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgresses()
    {
        return $this->hasMany(Progress::className(), ['material_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->post_scripts = 'function initMaterialJs'.$this->id.'(){';
            $this->content = $this->findAndReplaceWidgets($this->clear_html);
            $this->post_scripts.='}';
            return true;
        }
        return false;
    }

    private function findAndReplaceWidgets($html){
        $widgets = Widgets::findAll(['status'=>1]);

        foreach ($widgets as $idx=>$widget) {

            preg_match_all('#\<p\>\[' . $widget->template . '\]\<\/p\>(.+?)\<p\>\[\/' . $widget->template . '\]\<\/p\>#is', $html, $arr);
            $params = json_decode($widget->parameters);
            foreach ($arr[0] as $index => $item) {

                $string = rand(0, 99999); // уникальный идентификатор
                $el = $this->id;
                $replaceHtml = $widget->html;
                $replaceJs = $widget->js;

                foreach ($params as $param_index => $param) {
                    if($param == 'string'){
                        $replaceHtml = str_replace('['.$param_index.']', $arr[1][$index], $replaceHtml);
                    }elseif($param == 'element_id_in_database'){
                        $replaceHtml = str_replace('['.$param_index.']', $el, $replaceHtml);
                        $replaceJs = str_replace('['.$param_index.']',$el, $replaceJs);
                    }else{
                        $replaceHtml = str_replace('['.$param_index.']', $string, $replaceHtml);
                        $replaceJs = str_replace('['.$param_index.']',$string, $replaceJs);
                    }
                }

                $html = str_replace($item, $replaceHtml, $html);
                $this->post_scripts .= $replaceJs;
            }
        }

        return $html;
    }
}
