<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-store" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->endBody() ?>
    <!-- <link rel="stylesheet" href="static/css/main.css"/>-->
    <link rel="stylesheet" href="static/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="static/css/tablet.css"/>
    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/underscore-min.js"></script>
    <!-- <script src="//api.html5media.info/1.1.8/html5media.min.js"></script>-->
    <script src="static/js/jquery.clock.min.js"></script>
    <script src="static/js/jquery.liMarquee.js"></script>
    <script src="static/js/moment.min.js"></script>
    <script src="static/js/monitorRender.js"></script>

</head>
<body>
<?php $this->beginBody() ?>
<div class="content">
    <?= $content ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
