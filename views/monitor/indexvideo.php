<script>

	document.body.style.background = "#fff";


    $(document).ready(function () {
	
        var renderMonitor = new monitorQueueNew(<?=$tableDuration?>, null, true, 'commitregestryvoice');

        var objectSelectorMonitor = {
            thisAudioJquery: $('#voiceTest'),
            infoAboutActive: $('.infoAboutActive'),
            infoAboutNext: $('.infoAboutNext'),
            conteinerForOneNextTalon: $('.conteinerForOneNextTalon'),
            runingLine: $('#runingLine'),
            runingLineContainer: $('#scroller_container'),
            continerForVoice: $('.continerForVoice'),
            thisAudio: $('#voiceTest')[0],
            testForQueue: $('.testForQueue'),
            videoMy: document.getElementById('videoTest'),
            videoMyJquery: $('#videoTest')                 
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
         } */

        //videoMy.play();


        /*  objectSelectorMonitor.videoMy.onended = function () {
         objectSelectorMonitor.videoMy.currentTime = 0;
         objectSelectorMonitor.videoMy.load();
         objectSelectorMonitor.videoMy.play();
         };*/


        renderMonitor.startRender(objectSelectorMonitor, renderMonitor.renderTables);
        $('#clock').clock({time: {h:<?=date("G"); ?>, m:<?=date("i"); ?>, s: <?=date("s"); ?>}});
        //echo 'renderMonitor.startRuningLine(objectSelectorMonitor);';
        <?php if (isset($resultRuniningLine)) {echo 'renderMonitor.startRuningLine(objectSelectorMonitor);';} ?>

        //  objectSelectorMonitor.videoMy.play();
        //   $('#videoTest').play();

        // var audio = new Audio('exp/voice/TV_REG_116282.mp3');


        //setInterval(function(){audio.play();},5000);
        //setInterval(function(){audio.play();},5000);

        /*  document.getElementById('audioTest').load();
         document.getElementById('audioTest').play();*/
    });
</script>

<div class="conteinerMonitorTable" style="background-color: #fff;">
    <div class="testForQueue" style="font-size: 50px;"></div>

	<div class="fon-mon" 
		style="
			position: absolute;
			background-image: url(static/img/logo2.png);
			background-repeat: no-repeat;
			background-position: 50% 50%;
			width: 100%;
			height: 100%;
			opacity: 0.3;
	"></div>
	
    <div id="monitorTable" style="z-index: 9999; position: relative;">
        

<!--              <div class="leftPart"> -->

            <div style="height: 50%;">
                <div class="header" style="height: 85px;">
					<div style="float: left;"><img src="static/img/logo1.png"></div>
                    <div class="part date" style="margin-left: 20px;  margin-top: 18px;"><?= date("d.m"); ?></div>
                    <div style="margin-top: 18px;padding-left:50px;" class="part  namequeue">ЭЛЕКТРОННАЯ ОЧЕРЕДЬ В РЕГИСТРАТУРУ</div>
                    
					<div style="float: right;"><img src="static/img/logo2.png"></div>
					<div style="margin-top: 18px; margin-right: 20px;" id="clock" class="part timer"></div>
                </div>

                <p class="discription">НОМЕР ОЧЕРЕДИ</p>
                <div class="infoAboutActive">
                    <?php if (isset($talonWithStatusShow) && is_array($talonWithStatusShow)): ?>
                        <?php if (sizeof($talonWithStatusShow) > 0): ?>
                            <?php foreach ($talonWithStatusShow as $item => $values): ?>
                                <div class="oneActiveRoom">
                                    <div class="infoAboutTalon infoAboutRoom">
                                        <b class="activeTalon"><?= $values['CODE']; ?></b>
                                        <b class="activeRoom">&nbsp;-  <?= $values['ROOM']; ?></b>
                                    </div>
                                    <!-- <div class="infoAboutRoom">
                                     </div>-->
                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div style="clear: both; margin-top: 50%;">
                <div class="htmlTest"></div>
                <video src="video/videoNew1.mp4" poster="video/poster2.png" style="width: 0%;position:fixed;top:-1000px;" id="videoTest"> 
                </video>
                <style>figcaption {display: none;}</style>
            </div> 

<!--        </div>

        <div class="rightPart">

            <div style="height: 50%;">
                <div class="header">
                    <div class="part date"><?= date("d.m"); ?></div>
                    <div class="part  namequeue">ЭЛЕКТРОННАЯ ОЧЕРЕДЬ В РЕГИСТРАТУРУ</div>
                    <div id="clock" class="part timer"></div>
                </div>

                <p class="discription">НОМЕР ОЧЕРЕДИ</p>
                <div class="infoAboutActive">
                    <?php if (isset($talonWithStatusShow) && is_array($talonWithStatusShow)): ?>
                        <?php if (sizeof($talonWithStatusShow) > 0): ?>
                            <?php foreach ($talonWithStatusShow as $item => $values): ?>
                                <div class="oneActiveRoom">
                                    <div class="infoAboutTalon infoAboutRoom">
                                        <b class="activeTalon"><?= $values['CODE']; ?></b>
                                        <b class="activeRoom">&nbsp;-  <?= $values['ROOM']; ?></b>
                                    </div>
                                    <!-- <div class="infoAboutRoom">
                                     </div>-->
<!--                                      </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>      

            <div style="clear: both; margin-top: 50%;">
                <div class="htmlTest"></div>
                <video autoplay src="video/videoNew.mp4" poster="video/poster2.png" style="position:fixed;top:860px;width:50%;" id="videoTest1" loop="loop" preload="">
                </video>
                <style>figcaption {display: none;}</style>
            </div>

        </div> -->
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
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($resultRuniningLine)) {
                echo $resultRuniningLine;
            } ?>-->
        </div>

    </div>
    <div class="continerForVoice">
        <audio style="opacity: 0;position: absolute;top: -1000px;" id="voiceTest" preload="none"
               src="exp/voice/TV_REG_123456.mp3"></audio>
    </div>
    <? /*= $fileToVoice; */ ?>

</div>
