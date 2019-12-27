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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->endBody() ?>
    <link rel="stylesheet" href="static/css/main.css"/>
    <script src="static/js/jquery.min.js" ></script>
    <script src="static/js/jquery.print.js" ></script>
    <script src="static/js/test.js" ></script>
</head>
<script>
    $(document).ready(function () {
        $(".ajaxwait, .ajaxwait_image").hide();
        $(".ajaxwait, .ajaxwait_image").ajaxSend(function(event, xhr, options) {
            $(this).show();
        }).ajaxStop(function() {
            $(this).hide();
        });

        $(".hhome").click(function () {
            window.location.href='index.php';
        });

        $(".hback").not(".pat_n").click(function () {
            history.back();
        });

        // нажимание кнопки "ДОМОЙ"
        $(".hhome").mouseup(function () {
            $(this).removeClass("hhome_press");
            $(this).addClass("hhome");
        });
        $(".hhome").mousedown(function () {
            $(this).removeClass("hhome");
            $(this).addClass("hhome_press");
        });
        $(".hhome").mouseout(function () {
            $(this).removeClass("hhome_press");
            $(this).addClass("hhome");
        });

        // нажимание кнопки "НАЗАД"
        $(".hback").mouseup(function () {
            $(this).removeClass("hback_press");
            $(this).addClass("hback");
        });
        $(".hback").mousedown(function () {
            $(this).removeClass("hback");
            $(this).addClass("hback_press");
        });
        $(".hback").mouseout(function () {
            $(this).removeClass("hback_press");
            $(this).addClass("hback");
        });

        // сжимаем название специальности, если слишком длинное
        var span = $(".side_header .head_name").width();
        var pt = 30;
        while (span > 600)
        {
            pt -= 1;
            // изменить шрифт в спане
            $(".side_header").css("font-size", pt+"pt");
            var span = $(".side_header .head_name").width();
        }

        // для каждого!
        $(".yellow_button").each(function (i) {
            var span = $(this).children('span').height();
            var span_w = $(this).children('span').width();
            var pt = 30;
            while (span > 71 || span_w > 450)
            {
                pt -= 1;
                // изменить шрифт в спане
                $(this).css("font-size", pt+"pt");
                $(this).children('span').css("top", "15px");
                var span = $(this).children('span').height();
                var span_w = $(this).children('span').width();
            }
        });

        $(".go_home").click(function () {
            window.location.href = "index.php";
        });


    });
</script>
<body>

<?php $this->beginBody() ?>
<div class="ajaxwait"></div>
<div class="ajaxwait_image">
    <img src="static/img/ajaxloader.gif" />
</div>
<div class="header">
    <div class="img_header1"> <img src="static/img/logo1.png" /> </div> 
    <div class="center_header">
        <span class="head_name">
           <span class="first_part">ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ ВОЕННОЕ ОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ ВЫСШЕГО ОБРАЗОВАНИЯ</span> <br/>
           <span class="second_part">ВОЕННО-МЕДИЦИНСКАЯ АКАДЕМИЯ ИМЕНИ С. М. КИРОВА</span> <br/>
           <span class="second_part">Министерства обороны Российской Федерации</span>
        </span>
    </div>
    <div class="img_header2"> <img src="static/img/logo2.png" /> </div>
</div>
    <div class="home_n_back_buttons">
    </div>
    <div style="clear: both; "></div>
    <div class="side_header">
        <span class="head_name"><!--{$HEAD_NAME}--></span>
    </div>
    <div style="clear: both; "></div>


<div class="helper_for_patient" style="position: absolute; z-index: 1000; ">
    <span></span>
</div>
<div class="content">
            <?= $content ?>
</div>
<div class="footer">
    <div class="logo">
        <img src="static/img/logo.png">
    </div>
    <div class="footer_policlinic">
        <span><!--{$smarty.session.LU}--></span>
    </div>
    <div style="clear: both;"></div>
</div>
</body>
</html>
<?php $this->endPage() ?>
