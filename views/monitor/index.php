<script>
    $(document).ready(function () {

        var renderMonitor = new monitorQueueNew(<?=$tableDuration?>, null,null, 'commitregestryvoice');

        function testtest(){
            this.testMethod= function(){
                alert('1');
            }
        }

        testtest.prototype = renderMonitor;

        var what = new testtest();

        var objectSelectorMonitor = {
            thisAudioJquery: $('#voiceTest'),
            monitorTalonList: $('.monitor-talon-list'),
            tableTalonList: $('table.talon-list'),
            talonListBody: $('.talon-list-body'),
            infoAboutNext: $('.infoAboutNext'),
            conteinerForOneNextTalon: $('.conteinerForOneNextTalon'),
            runingLine: $('#runingLine'),
            runingLineContainer: $('#scroller_container'),
            continerForVoice: $('.continerForVoice'),
            thisAudio: $('#voiceTest')[0],
            testForQueue: $('.testForQueue'),
            videoMy: document.getElementById('videoTest')
        };
        /* var myVideo = document.getElementById('videoTest');


         function playPause() {
         if (myVideo.paused)
         myVideo.play();
         else
         myVideo.pause();
         }

         function makeBig() {
         myVideo.width = 560;
         }

         function makeSmall() {
         myVideo.width = 320;
         }

         function makeNormal() {
         myVideo.width = 420;
         }   */

        //videoMy.play();




      /*  objectSelectorMonitor.videoMy.onended = function () {
            objectSelectorMonitor.videoMy.currentTime = 0;
            objectSelectorMonitor.videoMy.load();
            objectSelectorMonitor.videoMy.play();
        };*/


        renderMonitor.startRender(objectSelectorMonitor, renderMonitor.renderTables);
//        renderMonitor.startRender(objectSelectorMonitor, renderMonitor.renderRuningLine(runingLine, runingLineContainer, "!!!!"));
        // $('#clock').clock({time: {h:<?=date("G"); ?>, m:<?=date("i"); ?>, s: <?=date("s"); ?>}});

        <?php if (isset($resultRuniningLine)) {echo 'renderMonitor.startRuningLine(objectSelectorMonitor);';} ?>

      //  objectSelectorMonitor.videoMy.play();
        //   $('#videoTest').play();

        // var audio = new Audio('exp/voice/TV_REG_116282.mp3');


        //setInterval(function(){audio.play();},5000);
        //setInterval(function(){audio.play();},5000);

        /*  document.getElementById('audioTest').load();
         document.getElementById('audioTest').play();*/
         $('table.talon-list').css('margin-top', ($('.monitor-talon-list').height() - $('table.talon-list').height()) / 2 * 0.9);
    });

    function checkTime(i) {
    return i < 10 ? ("0" + i) : i;
}

function getWeekDay(date) {
    var days = ['ВОСКРЕСЕНЬЕ', 'ПОНЕДЕЛЬНИК', 'ВТОРНИК', 'СРЕДА', 'ЧЕТВЕРГ', 'ПЯТНИЦА', 'СУББОТА'];
    return days[date.getDay()];
}

function getMonthLabel(date) {
    var days = ['ЯНВАРЯ', 'ФЕВРАЛЯ', 'МАРТА', 'АПРЕЛЯ', 'МАЯ', 'ИЮНЯ', 'ИЮЛЯ', 'АВГУСТА', 'СЕНТЯБРЯ', 'ОКТЯБРЯ', 'НОЯБРЯ', 'ДЕКАБРЯ'];
    return days[date.getMonth()];
}

function startTime() {
    var currentDate = new Date();

    var day = currentDate.getDate();
    var weekDay = getWeekDay(currentDate);
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();

    var hour = currentDate.getHours();
    var minute = currentDate.getMinutes();
    var seconds = currentDate.getSeconds();

    minute = checkTime(minute);
    month = checkTime(month);
    seconds = checkTime(seconds);
    day = checkTime(day);

    document.getElementById('date').innerHTML = day + "." + month + "." + year;
    document.getElementById('clock').innerHTML = hour + ":" + minute;
    document.getElementById('weekDay').innerHTML = weekDay;
}

window.onload = function () {
	setInterval(function() {
		startTime();
	}, 1000)
};

</script>
<header class="monitor-header">
    <div class="header-logo">
        <img src="images/logo_vtz.png" alt="#">
    </div>
    <div class="header-description">ЭЛЕКТРОННАЯ ОЧЕРЕДЬ В РЕГИСТРАТУРУ</div>
    <div class="header-date-time">
        <div class="date-container">
            <span id="date"></span>
            <span id="weekDay"></span>
        </div>
        <div class="time-container">
            <span id="clock" class=""></span>
        </div>
    </div>
</header>

<div class="monitor-talon-list">
    <div id="anti-fallout-margin-top"></div>
    <!-- <div class="testFo.rQueue"></div> -->
    <table class="talon-list">
        <tbody class="talon-list-body">
            <?php if (isset($talonWithStatusShow) && is_array($talonWithStatusShow)): ?>
                <?php if (sizeof($talonWithStatusShow) > 0): ?>
                    <?php $counter = 1;?>
                    <?php foreach ($talonWithStatusShow as $item => $values): ?>
                        <?php if (($counter % 2) != 0):?>
                            <tr class="talon-row-odd">
                                <td><div class="talon-number-odd activeTalon"><?= $values['CODE']; ?></div></td>
                                <td>&rarr;</td>
                                <td class="activeRoom"><?= $values['ROOM']; ?></td>
                            </tr>
                        <?php else:?>
                            <tr class="talon-row-even">
                                <td><div class="talon-number-even activeTalon"><?= $values['CODE']; ?></div></td>
                                <td>&rarr;</td>
                                <td class="activeRoom"><?= $values['ROOM']; ?></td>
                            </tr>
                        <?php endif;?>
                        <?php $counter++;?>    
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>    
        </tbody>
    </table>

    <div id="scroller_container">
        <div id="runingLine">
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

<footer id="bottomPart">
	<?php if (isset($lengthQueueList)):?>
	    <p class="queue_count">В очереди: <?= $lengthQueueList ?></p>
	<?php else: ?>
		<p class="queue_count"></p>
    <?php endif;?>
</footer>

