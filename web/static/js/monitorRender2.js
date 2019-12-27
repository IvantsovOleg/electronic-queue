var monitorQueueNew;

(function () {
    'use strict';
    var instance;
    /**
     * That function constructor
     * @param tableDurationParam - table with talons reload duration this value from db for that monitor
     * @param RunLineDurationParam - runingline  reload duration this value from db for that monitor
     * @param VideoDuration - video reload duration this value from db for that monitor
     * @param urlToSendAlreadySendVoices
     * @returns {*}
     */
    monitorQueueNew = function monitorQueueNew(tableDurationParam, RunLineDurationParam, VideoDuration, urlToSendAlreadySendVoices,timeWaitgToReloadpageParam) {
        if (instance) {
            return instance;
        }
        instance = this;
        /**
         *
         * @type {_|*|Window._} - underscore js
         */
        var underScore = _;
        /**
         *
         * @type {Window.moment|*} - moment js
         */
        var momentLib = moment;


        var vid = document.getElementById("videoTest");

        var videoFlag = VideoDuration;

        var tableDuration, RunLineDuration, isNeedSpeakDoctor, isNeedSpeakReg, timeLastRefresh, urlToSendAlreadySendVoices, timeWaitgToReloadpage;
        if (!underScore.isNull(tableDuration)) {
            tableDuration = tableDurationParam;
        } else {
            tableDuration = 5;
        }
        if (!underScore.isNull(RunLineDurationParam)) {
            RunLineDuration = RunLineDurationParam;
        }
        if (!underScore.isNull(urlToSendAlreadySendVoices)) {
            urlToSendAlreadySendVoices = urlToSendAlreadySendVoices;
        }


        timeLastRefresh = null;

        isNeedSpeakDoctor = true;

        isNeedSpeakReg = true;


        if (!underScore.isUndefined(timeWaitgToReloadpageParam)) {
            timeWaitgToReloadpage = timeWaitgToReloadpageParam;
        } else {
            timeWaitgToReloadpage = 21600;
        }


        /**
         *
         * @param urlToSendAlreadySendVoices - string url function in php controller, that  parametr defined in function constructor monitorQueueNew,
         * @param ids - string with ids with demiliter.
         */
        function sendAlreadySpokenRecordIds(urlToSendAlreadySendVoices, ids) {
            $.ajax({
                url: "index.php?r=monitor/" + urlToSendAlreadySendVoices,
                dataType: 'json',
                type: 'GET',
                data: {recordIds: ids},
                success: function (data) {
                    console.log(data);
                }
            });
        }

        /**
         *
         * @param ObjectSelectors
         * @param srcValue
         * @param idsToSendAlreadySpoken
         * @param durationVoice
         */

        var currentTime;

        function doctorSpeakVoice(ObjectSelectors, srcValue, idsToSendAlreadySpoken, durationVoice, strvoice) {

            var timeToSetTimeout;
            if (underScore.isUndefined(doctorSpeakVoice.arrayCallDoctor)) {
                doctorSpeakVoice.arrayCallDoctor = [];
                doctorSpeakVoice.arrayCallDoctor.push({
                    strVoice: strvoice,
                    file: 'exp/voice/' + srcValue + '.mp3',
                    ids: idsToSendAlreadySpoken,
                    duration: durationVoice
                });

            } else {
                if (!underScore.isNull(srcValue)) {
                    //alert()
                    doctorSpeakVoice.arrayCallDoctor.push({
                        strVoice: strvoice,
                        file: 'exp/voice/' + srcValue + '.mp3',
                        ids: idsToSendAlreadySpoken,
                        duration: durationVoice
                    });
                }
            }
            sendAlreadySpokenRecordIds(urlToSendAlreadySendVoices, doctorSpeakVoice.arrayCallDoctor[0].ids);
            isNeedSpeakDoctor = false;
            //doctorSpeakVoice.arrayCallDoctor[0].strVoice + '|' + doctorSpeakVoice.arrayCallDoctor[0].duration + '|' + doctorSpeakVoice.arrayCallDoctor.length + '|' + doctorSpeakVoice.arrayCallDoctor[0].file+ '|' + doctorSpeakVoice.arrayCallDoctor[0].ids

            ObjectSelectors.thisAudioJquery.attr('src', doctorSpeakVoice.arrayCallDoctor[0].file);
            ObjectSelectors.thisAudio.load();
            console.log(doctorSpeakVoice.arrayCallDoctor);

            // ObjectSelectors.thisAudio.load();
            //   $('.testForQueue').html('<div style="position: absolute;opacity: 0;">doctorSpeakVoice.arrayCallDoctor[0].file</div>');
            if (!underScore.isNull(videoFlag)) {
                /*   ObjectSelectors.videoMyJquery.css("opacity", "0.5");*/
                currentTime = ObjectSelectors.videoMy.currentTime;
            }

            // ObjectSelectors.thisAudio.play();


            timeToSetTimeout = calculateDuration(doctorSpeakVoice.arrayCallDoctor[0].duration);

            if (isNaN(timeToSetTimeout)) {
                timeToSetTimeout = 10000;
            }
            ObjectSelectors.thisAudio.play();


            setTimeout(function () {
                if (doctorSpeakVoice.arrayCallDoctor.length == 1) {
                    ObjectSelectors.videoMy.load();
                }
                //  if (doctorSpeakVoice.arrayCallDoctor.length > 0) {
                doctorSpeakVoice.arrayCallDoctor.shift();
                /* console.log(doctorSpeakVoice.arrayCallDoctor);*/
                // }
                /*if(!underScore.isUndefined(doctorSpeakVoice.arrayCallDoctor[0])){
                 $('.testForQueue').html(doctorSpeakVoice.arrayCallDoctor[0].file + '|' + doctorSpeakVoice.arrayCallDoctor[0].strVoice + '|' + doctorSpeakVoice.arrayCallDoctor.length);
                 }else{

                 }*/

                if (!underScore.isUndefined(doctorSpeakVoice.arrayCallDoctor[0])) {
                    doctorSpeakVoice(ObjectSelectors, null);
                    // $('.testForQueue').text('queue' + timeToSetTimeout + '|' + doctorSpeakVoice.arrayCallDoctor.length);
                } else {
                    isNeedSpeakDoctor = true;
                    // $('.testForQueue').text('empty' + timeToSetTimeout + '|' + doctorSpeakVoice.arrayCallDoctor.length);
                }

                if (!underScore.isNull(videoFlag)) {
                    setTimeout(function () {
                        if (doctorSpeakVoice.arrayCallDoctor.length == 0) {
                            ObjectSelectors.videoMy.play();
                            ObjectSelectors.videoMy.play();
                            ObjectSelectors.videoMyJquery.css("opacity", "1");
                            ObjectSelectors.videoMy.currentTime = currentTime;
                        }
                    }, 2000);
                }


            }, timeToSetTimeout);

            /**
             * function calculate time to setTimeout, that time is length mp3 file in seconds + 1 second
             * @returns {number}
             */
            function calculateDuration(duration) {
                return (duration + 3) * 1000;
            }
        }

        /**
         *  function calculate 6 hour to reload
         * @param timeStamp - timestamp from server
         */
        function calculateIsNeedReload(timeStamp) {
            if (underScore.isNull(timeLastRefresh)) {
                timeLastRefresh = timeStamp;
            } else {
                //3600 //21600
                if ((timeStamp - timeLastRefresh) > timeWaitgToReloadpage) {
                    window.location.reload();
                }
            }
        }


        /**
         * Function rendering table with talons
         * @param ObjectSelectors - objects with link to selectors
         */
        this.renderTables = function (ObjectSelectors) {

            $.ajax({
                url: "index.php?r=monitor/rendermonitor",
                dataType: 'json',
                timeout: 3000,
                error: function () {
                    console.log('test')
                },
                success: function (data) {
                    //   console.log(data);
                    var activeString = '';
                    var pactiveString = '';
                    for (var i = 0; i < data.talonWithStatusShow.length; i++) {
                        activeString += '<div class="oneActiveRoom"><div class="infoAboutTalon infoAboutRoom"><b class="activeTalon">' + data.talonWithStatusShow[i].CODE + '</b><b class="activeRoom"> - ' + data.talonWithStatusShow[i].ROOM + '</b></div> <div class="infoAboutRoom"></div></div>';
                    }
                    if (underScore.isNull(videoFlag)) {
                        for (var c = 0; c < data.talonWithStatusHide.length; c++) {
                            pactiveString += '<div  class="conteinerForOneNextTalon"><div  class="nextTalons">' + data.talonWithStatusHide[c].CODE + '</div> <div class="room">- ' + data.talonWithStatusHide[c].ROOM + '</div></div>';
                        }
                    }
                    calculateIsNeedReload(data.timeStamp);
                    ObjectSelectors.infoAboutActive.html(activeString);

                    if (underScore.isNull(videoFlag)) {
                        ObjectSelectors.infoAboutNext.html(pactiveString);
                    }
                    if (isNeedSpeakDoctor && data.durationFileToSpeak > 0) {

                        doctorSpeakVoice(ObjectSelectors, data.voiceNow, data.stringTalonIds, parseInt(data.durationFileToSpeak, 10), data.stringVoice);
                    } else {
                        if (data.durationFileToSpeak > 1) {
                            doctorSpeakVoice.arrayCallDoctor.push({
                                strVoice: data.stringVoice,
                                file: 'exp/voice/' + data.voiceNow + '.mp3',
                                ids: data.stringTalonIds,
                                duration: parseInt(data.durationFileToSpeak, 10)
                            });
                            console.log(doctorSpeakVoice.arrayCallDoctor);
                        }

                    }


                    // ObjectSelectors.videoMy.play();
                }
            });
        };
        /**
         * Function rendering table with talons
         * @param ObjectSelectors - objects with link to selectors
         */
        this.renderDoctorMonitor = function (ObjectSelectors, isNeedPushToQueue) {
            var testQueue = '';
            var stringToRender = '';
            var activeTalon, waitingTalon;
            $.ajax({
                url: "index.php?r=monitor/monitordoctor",
                dataType: 'json',
                timeout: 3000,
                error: function () {
                    console.log('test')
                },
                success: function (data) {
                    for (var selector in data.data) {
                        if (data.data[selector]['room']) {
                            if (!underScore.has(data.data[selector], 'stringpas')) {
                                waitingTalon = '';
                            } else {
                                waitingTalon = data.data[selector]['stringpas'];
                            }
                            if (!underScore.has(data.data[selector], 'stringactive')) {
                                activeTalon = '';
                            } else {
                                activeTalon = data.data[selector]['stringactive'];
                            }
                            if (underScore.isNull(videoFlag)) {
                                stringToRender += '<div class="row" id="' + data.data[selector]['room'] + '"><div class="col-xs-6 col-sm-4 rooms head">' + data.data[selector]['room'] + '&nbsp;&nbsp;</div><div class="col-xs-6 col-sm-4 stringactive head">' + activeTalon +
                                    '</div><div class="col-xs-6 col-sm-4 stringpas pull-right head rightCol">' + waitingTalon + '&nbsp;&nbsp;</div> </div>';

                            } else {
                                stringToRender += '<div class="row" id="' + data.data[selector]['room'] + '">&nbsp;&nbsp;<div class="col-xs-6 col-sm-6 rooms head">' + data.data[selector]['room'] + '&nbsp;&nbsp;</div><div class="col-xs-6 col-sm-6 stringactive head">' + activeTalon +
                                    '&nbsp;&nbsp;</div></div>';
                            }
                            ObjectSelectors.roomsConteiner.html(stringToRender);
                        } else {
                            ObjectSelectors.roomsConteiner.html('&nbsp;&nbsp;&nbsp;&nbsp;');
                        }

                    }
                    calculateIsNeedReload(data.timeStamp);
                    // isNeedSpeak
                    if (!underScore.isNull(data.isNeedSpeak)) {
                        if (isNeedSpeakDoctor && data.durationFileToSpeak > 1) {
                            doctorSpeakVoice(ObjectSelectors, data.voiceNow, data.testRecordIds, parseInt(data.durationFileToSpeak, 10));
                        } else {
                            if (data.durationFileToSpeak > 0) {
                                doctorSpeakVoice.arrayCallDoctor.push({
                                    file: 'exp/voice/' + data.voiceNow + '.mp3',
                                    ids: data.testRecordIds,
                                    duration: parseInt(data.durationFileToSpeak, 10)
                                });
                            }
                        }
                    }
                }
            });
        };


        /**
         * Function monitoring changes in db oracle, 3 status, table with talons, video, runingLine
         * @param ObjectSelectors - objects with link to selectors
         */
        this.setSetInterval = function (ObjectSelectors, functionRender) {

            $.ajax({
                url: "index.php?r=monitor/monitoringshanges",
                dataType: 'json',
                success: function (data) {

                    if (underScore.isNull(timeLastRefresh)) {
                        timeLastRefresh = data.timeStamp;
                    }

                    /*if (!underScore.isNull(RunLineDuration)) {
                     if ((data.timeStamp - timeLastRefresh) > RunLineDuration) {
                     functionRender(ObjectSelectors);
                     timeLastRefresh = data.timeStamp;
                     }
                     }*/
                    //data.data.TALON = 1;

                    if (data.data.TALON == 1) {
                        timeLastRefresh = data.timeStamp;
                        functionRender(ObjectSelectors, true);
                    }
                    //console.log(data);
                    /*  if ((data.timeStamp - timeLastRefresh) > tableDuration) {
                     timeLastRefresh = data.timeStamp;
                     functionRender(ObjectSelectors, true);
                     }*/
                }
            });
        };
        /**
         *
         * @param selectorTextRiningLine - link to selector
         * @param selectorConteinerRiningLine - link to selector
         * @param newText - text to runing line
         */
        this.renderRuningLine = function (selectorTextRiningLine, selectorConteinerRiningLine, newText) {
            selectorTextRiningLine.text(newText);
            selectorConteinerRiningLine.liMarquee('update');
        };

        this.startRender = function (objectSelectorMonitor, functionRender) {

            if (!underScore.isNull(videoFlag)) {
                objectSelectorMonitor.videoMy.play();
            }

            setInterval(function () {
                functionRender(objectSelectorMonitor);
            }, tableDuration);


        };


        this.startRuningLine = function (objectSelectorMonitor) {
            objectSelectorMonitor.runingLineContainer.liMarquee({
                direction: 'left',
                loop: -1,
                scrolldelay: 200,
                scrollamount: 50,
                circular: false,
                hoverstop: false,
                drag: false
            });
        };

    }


})();


