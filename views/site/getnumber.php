<div class="contentMainPage">
    <div style="position: absolute;top: -100px" id="testtest"></div>

    <div class="conteinerFotButtom">
        <?php

        if (isset($result) && is_array($result)) {
            for ($i = 0; $i < count($result); $i++) {
                if(isset($result[$i]['RGB'])){
                    $rgb = $result[$i]['RGB'];
                }else{
                    $rgb = null;
                }
                if (strlen($result[$i]['TEXT']) > 10) {
                    setWidth($result[$i], 860, $result[$i]['IS_NEED_AUTH'], $rgb);
                } else {
                    setWidth($result[$i], 560, $result[$i]['IS_NEED_AUTH'], $rgb);
                }
            }
        } else {
            echo 'Ошибка получения данных, проверьте работу xml сервера';
        }


        function setWidth($result, $textFieldLieght, $isNeddAuth, $rgb)
        {
           // background-color: $colorBottom;
            if (!is_null($rgb)) {
                //;box-shadow: inset 0px -3px 0px 0px #' . $rgb .', inset 0px 3px 0px 0px #'  . $rgb .';
                $color = 'background-color:#' . $rgb . ';background:#' . $rgb.';';
            } else {
                $color = '';
            }
            $namequeue = str_replace(" ", "&nbsp", $result['TEXT']);
            if ((int)$isNeddAuth !== 1) {

                echo '<p><a class="classButtom orangeButtom" style="' . $color . 'min-width:' . $textFieldLieght . 'px" href="index.php?r=site/printnumber&keyid=' . $result['KEYID'] . '&namequeue=' . $result['TEXT'] . '" style="-moz-user-select: none;">' . $namequeue . ' </a></p>';
            } else {
                echo '<p><a class="classButtom orangeButtom" style="' . $color . 'min-width:' . $textFieldLieght . 'px" href="index.php?r=site/authpatient&keyid=' . $result['KEYID'] . '&namequeue=' . $result['TEXT'] . '" style="-moz-user-select: none;">' . $namequeue . ' </a></p>';
            }
        }

        ?>
    </div>


<!--    <div class="conteinerForImgHome">
        <img src="static/img/icons/ICON_Home_big.png">
    </div> -->
    <div class="conteinerForInstruction">
        <div class="text"><?= $lpuInstruction ?></div>
    </div>
</div>