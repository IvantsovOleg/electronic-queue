<script>

    $(document).ready(function () {

        var renderMonitor = new monitorQueueNew(<?=$tableDuration?>, null, null, 'commitdoctorvoice');
        var objectSelectorMonitor;
        objectSelectorMonitor = {
            thisAudioJquery: $('#voiceTest'),
            rooms: $('.bodyTable>.row'),
            roomsConteiner: $('.bodyTable'),
            audio: document.getElementById('audioInDoctor'),
            runingLine: $('#runingLine'),
            runingLineContainer: $('#scroller_container'),
            continerForVoice: $('.continerForVoice'),
            thisAudio: $('#voiceTest')[0],
            testForQueue: $('.testForQueue')
        };

        renderMonitor.startRender(objectSelectorMonitor, renderMonitor.renderDoctorMonitor);
        $('#clock').clock({time: {h:<?=date("G"); ?>, m:<?=date("i"); ?>, s: <?=date("s"); ?>}});

        <?php if (isset($resultRuniningLine)) {echo 'renderMonitor.startRuningLine(objectSelectorMonitor);';} ?>
    });


</script>
<div class="conteinerMonitorTable">
    <div id="monitorTable">
        <div class="header">
            <div class="part date"><?= date("d.m"); ?></div>
            <div class="part  namequeue">ЭЛЕКТРОННАЯ ОЧЕРЕДЬ В КАБИНЕТ</div>
            <div id="clock" class="part timer"></div>
        </div>
        <div id="conteinerForMonitorDoctor">
            <div class="testForQueue"></div>

            <div class="headerTable">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 head"><span>КАБИНЕТ</span></div>
                    <div class="col-xs-6 col-sm-4 head"><span>НА ПРИЕМ</span></div>
                    <div class="col-xs-6 col-sm-4 head"><span>СЛЕДУЮЩИЕ</span></div>
                </div>
            </div>
            <div class="conteinerForMonitorWithOutVideo">
                <div class="bodyTable" style="min-height: 600px;">

                    <!--       --><?php /*print_r($resultTvTalon); */ ?>

                    <?php foreach ($resultTvTalon as $key => $subResultTvTalon): ?>
                        <div class="row" id="<?= $key ?>">
                            <div class="col-xs-6 col-sm-4 rooms head"><?php echo $key; ?></div>


                            <?php if (!array_key_exists('stringactive', $subResultTvTalon)) {
                                $subResultTvTalon['stringactive'] = '<div class="notVisible">пусто</div>';
                            }; ?>
                            <?php foreach ($subResultTvTalon as $key2 => $subResultTvTalon2): ?>
                                <?php

                                if ($key2 == 'stringactive') {
                                    if (!is_array($subResultTvTalon2)) {
                                        echo '<div class="col-xs-6 col-sm-4 stringactive head">' . $subResultTvTalon2 . '</div>';
                                    }

                                }

                                ?>
                                <?php
                                if ($key2 == 'stringpas') {
                                    if (!is_array($subResultTvTalon2)) {
                                        echo '<div class="col-xs-6 col-sm-4 stringpas pull-right head rightCol">' . $subResultTvTalon2 . '</div>';
                                    }
                                }
                                ?>
                            <?php endforeach; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


        </div>
    </div>
    <div>
        <audio id="audioInDoctor" style="opacity: 0;position: absolute;top:-2000px" src="<?= $fileToVoice ?>"></audio>
    </div>
    <div id="scroller_container">

        <div id="runingLine">
            <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
            <?php if (isset($resultRuniningLine)) {
                echo $resultRuniningLine;
            } ?>
        </div>

    </div>
    <div class="continerForVoice">
        <audio style="opacity: 0;position: absolute;top: -1000px;" id="voiceTest" preload="none"
               src="<?= $fileToVoice; ?>"></audio>
    </div>

</div>
