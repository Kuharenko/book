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

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
<div class="page-wrap">
    <div class="main-menu">
        <a class="main-menu__item" href="/">
            <i class="far fa-user"></i>
        </a>
        <a class="main-menu__item" href="/categories">
            <i class="fas fa-certificate"></i>
        </a>
        <a class="main-menu__item" href="/vocabulary">
            <i class="fas fa-edit"></i>
        </a>
        <a class="main-menu__item" href="/progress">
            <i class="fas fa-clipboard"></i>
        </a>

    </div>
    <div class="container">


<?php $this->beginBody() ?>

        <?= $content ?>

<?php $this->endBody() ?>
    </div>
</div>

</body>
</html>
<?php $this->endPage() ?>
