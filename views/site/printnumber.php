<div id="printTalonPage">
    <div class="discriptionGoodPrint"><p class="staticWords">Результат печати</p>

        <?php
        if (isset($result[0]['MESSAGE'])) {
            $messege = $result[0]['MESSAGE'];
        } else {
            $messege = '';
        }
        ?>
        <p class="dinamicWords"><?= $messege ?></p></div>
    <div class="conteinerForButtom">
        <p><a id="back" class="classButtom return-home" href="http://ariadna.vmeda.local/kiosk2/">Вернуться на главную страницу</a></p>
    </div>

    <div class="printFakeButtom"></div>

</div>

<script>
    <?php if ($result[0]['TALON_ID'] > 0): ?>

    $(document).ready(function () {

        $(".printFakeButtom").printPage({
            url: "static/print/print_a5_2.php?talon_id=<?=$result[0]['TALON_ID']?>&talon_code=<?=$result[0]['TALON_CODE']?>&barcode=<?=$result[0]['BARCODE']?>&namequeue=<?=$namequeue?>&dopinfo=<?=$dopinfo?>",
            attr: "href",
            message: "Печать произошла успешно",
            showMessage: false,
            callback: function () {
                setTimeout(function () {
                    window.location.href = 'http://ariadna.vmeda.local/kiosk2/'
                }, 3000);
            }

        });
        function startPrint() {
            $('.printFakeButtom').trigger('click');
        }

        setTimeout(startPrint, 1000);
    });


    <?php else: ?>
    setTimeout(function () {
        window.location.href = 'index.php?r=site/index'
    }, 3000);
    <?php endif; ?>
</script>