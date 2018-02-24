<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="page-wrap">
    <div class="main-menu">
        <a class="main-menu__item" href="#">
            <i class="far fa-user"></i>
        </a>
        <a class="main-menu__item" href="#">
            <i class="fas fa-certificate"></i>
        </a>
        <a class="main-menu__item" href="#">
            <i class="fas fa-edit"></i>
        </a>
        <a class="main-menu__item" href="#">
            <i class="fas fa-clipboard"></i>
        </a>
        <a class="main-menu__item" href="#">
            <i class="fas fa-building"></i>
        </a>
    </div>
    <div class="container">
        <div class="content">
     <div id="app">
                <p>
                    <!-- используйте компонент router-link для создания ссылок -->
                    <!-- входной параметр `to` определяет путь для перехода -->
                    <!-- `<router-link>` по умолчанию преобразуется в тег `<a>` -->
                    <router-link to="/foo">Получить посты</router-link>
                    <br>
                    <router-link to="/bar">Удалить посты</router-link>
                </p>
                <!-- отображение компонента, для которого совпал путь -->
                <router-view></router-view>
            </div>
            <div id="app2">
                <h2>{{message}}</h2>

                <div class="post" v-for="post in posts">
                    <div class="title">
                        <a :href="/post/ + post.id">{{ post.name }}</a>
                        <br>
                        <div>
                            <span v-for="category in post.categories"><b>{{category.name}} </b></span>
                        </div>
                        <p>{{ post.content }}</p>
                    </div>
                </div>


            </div>


        </div>
    </div>
</div>
<?php $this->beginBody() ?>

<!--        --><?//= $content ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
