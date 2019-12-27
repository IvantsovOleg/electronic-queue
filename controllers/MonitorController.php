<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use yii\base\Component;


class MonitorController extends Controller
{
    public $fileToVoice = null;

    public function actionIndex()
    {
        if (isset($_GET['tvcode']) && trim(Yii::$app->request->get('tvcode')) !== '') {
            $session = new Session;
            $session->open();

            Yii::$app->session['tvCode'] = $tvCode = Yii::$app->request->get('tvcode');


            $this->layout = "monitorqueue";
            $command = 'ELECTRONICQUEUE_GET_DEVICE_ID_BY_CODE';
            $params = array(array("NAME" => "P_DEVICE_CODE", "VALUE" => Yii::$app->session['tvCode']));
            $result = '';
            $errorMsg = '';
            Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);
            if (isset($result)) {
                if (!isset($result[0])) {
                    echo 'Некорректные данные от процедуры, возможно ошибка';
                    return;
                }
                Yii::$app->session['DEVICE_ID'] = $result[0]['DEVICE_ID'];
            }

            $command = 'ELECTRONICQUEUE_TV_GET_PLAYLIST_ITEMS';
            $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
            $result = '';
            $errorMsg = '';
            Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

            Yii::$app->cxml->handlerErros($errorMsg);
            if (isset($result)) {
                Yii::$app->session['settingsToRenderMonitor'] = $result;
                Yii::$app->session['playListCommand'] = Yii::$app->cmonitor->setConfigPlayList($result);
            }

            if (strpos($tvCode, 'TAB')) {
                return $this->redirect(['monitortablets']);
            } else if (!strpos($tvCode, 'DOCTOR')) {
                return $this->redirect(['rendermonitor']);
            } else {
                return $this->redirect(['monitordoctor']);
            }


        } else {
            echo 'Вы не заполнили значение параметра "tvcode" идентифицируюущего устройство, заполните его в url строке браузера "monitorqueue/index&tvcode==НУЖНОЕ ЗНАЧЕНИЕ" (тестовое значение TV_REG_1)';
        }

    }

    public function actionRendermonitor()
    {

        set_time_limit(100);

        if (isset(Yii::$app->session['settingsToRenderMonitor']) && isset(Yii::$app->session['DEVICE_ID'])) {
            //   Yii::$app->session['tvCode'] = 'TV_REG_1';
            $request = Yii::$app->request;

            $baseUrl = Yii::$app->request->getBaseUrl();
            $host = Yii::$app->request->hostInfo . $baseUrl;
            //$deviceId =1;
			
			$showLength = true;
			$resultLengthQueueList = null;
			
            $deviceId = Yii::$app->session['DEVICE_ID'];

            $playListCommand = Yii::$app->session['playListCommand'];

            $this->layout = "monitorqueue";

            if (isset($playListCommand['commandRuningLine']['text'])) {
                $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => $deviceId));
                $result = '';
                $errorMsg = '';
                Yii::$app->cxml->makeRequest($playListCommand['commandRuningLine']['text'], $params, $result, $errorMsg);
                $resultRuniningLine = $result[0]['TEXT'];
            } else {
                $resultRuniningLine = null;
            }
			
			
			if ($showLength) {
                $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => $deviceId));
                $result = '';
                $errorMsg = '';
                Yii::$app->cxml->makeRequest('ELECTRONICQUEUE_TV_LENGTH_LIST_FOR_REG', $params, $result, $errorMsg);
                $resultLengthQueueList = $result[0]['text'];
            } else {
                $resultLengthQueueList = null;
            }
					
            $playListCommand = [];
            $playListCommand['commandTalonList'] = [];
            $playListCommand['commandTalonList']['list'] = 'ELECTRONICQUEUE_TV_TALON_LIST_FOR_REG';
            if (isset($playListCommand['commandTalonList']['list'])) {
                $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => $deviceId));
                $result = '';
                $errorMsg = '';
                Yii::$app->cxml->makeRequest($playListCommand['commandTalonList']['list'], $params, $result, $errorMsg);

                $resultTvTalon = $result;

                $tableDuration = Yii::$app->session['playListCommand']['commandTalonList']['duration'];

                $talonWithStatusShow = [];
                $talonWithStatusHide = [];
                $talonWithStatusVoice = [];

                $stringVoice = '';
                $stringTalonIds = '';
                $fileToVoice = '';
                $durationFileToSpeak = 0;

                if (isset($resultTvTalon)) {
                    if (is_array($resultTvTalon)) {
                        if (sizeof($resultTvTalon) > 0) {
                            foreach ($resultTvTalon as $key => $value) {
                                if ((int)$value['STATUS'] === 1) {
                                    array_push($talonWithStatusShow, $value);
                                } else {
                                    array_push($talonWithStatusHide, $value);
                                }
                                if ((int)$value['IS_NEED_VOICE'] === 1) {
                                    array_push($talonWithStatusVoice, $value);
                                    if ($stringTalonIds == '') {
                                        $stringTalonIds .= $value['RECORD_ID'];
                                    } else {
                                        $stringTalonIds .= ',' . $value['RECORD_ID'];
                                    }

                                    if (isset($value['VOICE'])) {
                                        if ($stringVoice == '') {
                                            $stringVoice .= $value['VOICE'];
                                        } else {
                                            $stringVoice .= '#' . $value['VOICE'];
                                        }
                                    }
                                }
                            }

                            $countCall = Yii::$app->cmonitor->counterTest();
                            $this->fileToVoice = Yii::$app->session['tvCode'] . $countCall;
                            if (sizeof($talonWithStatusVoice) > 0) {
                                if (!file_exists('exp/voice/' . $this->fileToVoice . '.mp3')) {
                                    fopen('exp/voice/' . $this->fileToVoice . '.mp3', "w+");
                                }
                                $isNeedSpeak = true;
                                $durationFileToSpeak = Yii::$app->cmonitor->bondingMp3TalonFiles($stringVoice, $host, $this->fileToVoice);


                                /*echo $durationFileToSpeak;*/
                            } else {
                                $isNeedSpeak = null;
                                $durationFileToSpeak = 0;
                            }



                            $fileToVoice = 'exp/voice/' . $this->fileToVoice . '.mp3';


                        }
                    }
                }

                //$tableDuration = 5000;

                if ($request->getIsAjax()) {
                    echo json_encode(array(
                        'talonWithStatusShow' => $talonWithStatusShow,
                        'talonWithStatusHide' => $talonWithStatusHide,
                        'tvcode' => Yii::$app->session['tvCode'],
                        'voiceNow' => $this->fileToVoice,
                        'stringTalonIds' => $stringTalonIds,
                        'durationFileToSpeak' => $durationFileToSpeak,
                        'stringVoice' => $stringVoice,
                        'timeStamp' => date_timestamp_get(date_create()),
						'lengthQueueList' => $resultLengthQueueList
                    ));
                } else {
                    if(is_null(Yii::$app->session['playListCommand']['commandVideo'])){
                        return $this->render('index',
                            ['resultTvTalon' => $resultTvTalon,
                                'resultRuniningLine' => $resultRuniningLine,
                                'fileToVoice' => $fileToVoice,
                                'tableDuration' => $tableDuration,
                                'talonWithStatusShow' => $talonWithStatusShow,
                                'talonWithStatusHide' => $talonWithStatusHide,
								'lengthQueueList' => $resultLengthQueueList
                            ]);
                    }else{
                        return $this->render('indexvideo',
                            ['resultTvTalon' => $resultTvTalon,
                                'resultRuniningLine' => $resultRuniningLine,
                                'fileToVoice' => $fileToVoice,
                                'tableDuration' => $tableDuration,
                                'talonWithStatusShow' => $talonWithStatusShow,
                                'talonWithStatusHide' => $talonWithStatusHide,
								'lengthQueueList' => $resultLengthQueueList
                            ]);
                    }

                }


            } else {
                echo 'Ошибка, Заполните плейлист для данного устройства, это можно сделать в админ панеле  или напрямую в db';
            }


        } else {
            echo 'Ошибка получения данных плейлиста для данного устройства, возможно вы вы не заполнили значение параметра "tvcode" идентифицируюущего устройство, заполните его в url строке браузера "monitorqueue/index&tvcode==НУЖНОЕ ЗНАЧЕНИЕ" (тестовое значение TV_REG_1)';
        }


    }


    public function actionMonitordoctor()
    {

        set_time_limit(100);
        $request = Yii::$app->request;

        $baseUrl = Yii::$app->request->getBaseUrl();
        $host = Yii::$app->request->hostInfo . $baseUrl;


        $playListCommand = Yii::$app->session['playListCommand'];


        $this->layout = "monitorqueue";



        if (isset($playListCommand['commandRuningLine']['text'])) {
            $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" =>Yii::$app->session['DEVICE_ID']));
            $result = '';
            $errorMsg = '';
            Yii::$app->cxml->makeRequest($playListCommand['commandRuningLine']['text'], $params, $result, $errorMsg);
            $resultRuniningLine = $result[0]['TEXT'];
        } else {
            $resultRuniningLine = null;
        }


        $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
        $result = '';
        $errorMsg = '';
        Yii::$app->cxml->makeRequest($playListCommand['commandTalonList']['list'], $params, $result, $errorMsg);


        $resultTvTalon = Yii::$app->cmonitor->comliteArrayToDoctorMonitor($result);

        $testVoice = '';
        $testRecordIds = '';
        $durationFileToSpeak = 0;
        $isNeedSpeak = null;
        $fileToVoice = '';
        //print_r(Yii::$app->session['playListCommand']);
        $tableDuration = Yii::$app->session['playListCommand']['commandTalonList']['duration'];
        if (isset($resultTvTalon)) {
            if (is_array($resultTvTalon)) {
                if (sizeof($resultTvTalon) > 0) {

                    foreach ($resultTvTalon as $key => $value) {
                        if ($value['IS_NEED_VOICE'] == 1) {
                            if ($testVoice == '') {
                                if (isset($value['VOICE']) && $testVoice == '') {
                                    $testVoice = $value['VOICE'];
                                }
                            } else {
                                if (isset($value['VOICE'])) {
                                    $testVoice .= '#' . $value['VOICE'];
                                }
                            }
                        }
                        if ($testRecordIds === '' && isset($value['RECORD_IDS'])) {
                            $testRecordIds = $value['RECORD_IDS'];
                        }
                    }

                    $countCall = Yii::$app->cmonitor->counterTest();
                    $this->fileToVoice = Yii::$app->session['tvCode'] . $countCall;

                    if ($testVoice != '') {
                        if (!file_exists('exp/voice/' . $this->fileToVoice . '.mp3')) {
                            fopen('exp/voice/' . $this->fileToVoice . '.mp3', "w+");
                        }
                        $isNeedSpeak = true;
                        $durationFileToSpeak = Yii::$app->cmonitor->bondingMp3TalonFiles($testVoice, $host, $this->fileToVoice);
                    } else {
                        $isNeedSpeak = null;
                        $durationFileToSpeak = 0;
                    }
                    // $tableDuration = 5000;

                    $fileToVoice = 'exp/voice/' . $this->fileToVoice . '.mp3';

                }
            }
        }
        //$tableDuration = 5000;


        if ($request->getIsAjax()) {

            echo json_encode(array(
                'data' => $resultTvTalon,
                'voiceNow' => $this->fileToVoice,
                'testRecordIds' => $testRecordIds,
                'durationFileToSpeak' => $durationFileToSpeak,
                'isNeedSpeak' => $isNeedSpeak,
                'timeStamp' => date_timestamp_get(date_create())
            ));

        } else {
            if(is_null(Yii::$app->session['playListCommand']['commandVideo'])){
                return $this->render('doctor', [
                    'resultTvTalon' => $resultTvTalon,
                    'fileToVoice' => $fileToVoice,
                    'tableDuration' => $tableDuration,
                    'resultRuniningLine' => $resultRuniningLine,
                ]);

            }else{
                return $this->render('doctorvideo', [
                    'resultTvTalon' => $resultTvTalon,
                    'fileToVoice' => $fileToVoice,
                    'tableDuration' => $tableDuration,
                    'resultRuniningLine' => $resultRuniningLine,
                ]);
            }




        }

    }


    public function actionMonitortablets()
     {
        set_time_limit(100);
        $request = Yii::$app->request;

        $baseUrl = Yii::$app->request->getBaseUrl();
        $host = Yii::$app->request->hostInfo . $baseUrl;

        $playListCommand = Yii::$app->session['playListCommand'];
        
        $this->layout = "tablet";

        if (isset($playListCommand['commandTalonList']['list'])) {
            $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" =>Yii::$app->session['DEVICE_ID']));
            $result = '';
            $errorMsg = '';
            Yii::$app->cxml->makeRequest($playListCommand['commandTalonList']['list'], $params, $result, $errorMsg);
            $resultRuniningLine = $result[0];

            if ($request->getIsAjax()) {

                echo json_encode(array(
				'device' => Yii::$app->session['DEVICE_ID'],
                    'data' => $resultRuniningLine,
                    'timeStamp' => date_timestamp_get(date_create())
                ));

            } else { 
               
                return $this->render('tablets', [
                    'data' => $resultRuniningLine,
                ]);
            }



        } else {
            echo Yii::$app->session['DEVICE_ID'] . ' Ошибка, Заполните плейлист для данного устройства, это можно сделать в админ панеле  или напрямую в db';
            return;
            }

        }
    

    public function actionRendertableajax()
    {
        $baseUrl = Yii::$app->request->getBaseUrl();
        $host = Yii::$app->request->hostInfo . $baseUrl;
        $this->fileToVoice = Yii::$app->session['tvCode'];

        $command = 'ELECTRONICQUEUE_TV_TALON_LIST_FOR_REG';
        $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
        $result = '';
        $errorMsg = '';
        Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

        //   shuffle($result);

        $activeTalon = array_shift($result);

        $countCall = Yii::$app->cmonitor->counterTest();
        $this->fileToVoice = Yii::$app->session['tvCode'] . $countCall;

        $durationFileToSpeak = Yii::$app->cmonitor->bondingMp3TalonFiles($activeTalon['VOICE'], $host, $this->fileToVoice);


        $nextTalons = $result;

        echo json_encode(array(
            'active' => $activeTalon,
            'nexttalons' => $nextTalons,
            'tvcode' => Yii::$app->session['tvCode'],
            'voiceNow' => $this->fileToVoice,
            'durationFileToSpeak' => $durationFileToSpeak
        ));
    }


    public function actionRenderrunningline()
    {

        $arraySettingsToRenderMonitor = Yii::$app->session['settingsToRenderMonitor'];
        for ($i = (count($arraySettingsToRenderMonitor) - 1); $i >= 0; $i--) {
            if ((int)$arraySettingsToRenderMonitor[$i]['ITEM_TYPE'] === 2) {
                $commandRuningLine = $arraySettingsToRenderMonitor[$i]['QUERY'];
            }
        }

        if (isset($commandRuningLine)) {
            $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
            $result = '';
            $errorMsg = '';
            Yii::$app->cxml->makeRequest($commandRuningLine, $params, $result, $errorMsg);
            $resultRuniningLine = $result[0]['TEXT'];
        } else {
            $resultRuniningLine = null;
        }
        echo json_encode(array('data' => $resultRuniningLine));
    }


    public function actionCommitdoctorvoice()
    {

        $request = Yii::$app->request;

        $deviceId = Yii::$app->session['DEVICE_ID'];
        if ($request->getIsGet()) {

            $arrayRecordIds = $request->get('recordIds');

            $command = 'ELECTRONICQUEUE_TV_TALON_RECORD_VOICE_COMMIT';

            $result = '';
            $errorMsg = '';

            if (isset($arrayRecordIds)) {
                $params = array(
                    array("NAME" => "P_TALON_RECORD_ID", "VALUE" => $arrayRecordIds),
                    array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
            } else {
                $params = array(
                    array("NAME" => "P_TALON_RECORD_ID", "VALUE" => ''),
                    array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
            }

            Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

            echo json_encode(array('data' => $result));
        }
    }

    public function actionCommitregestryvoice()
    {

        $request = Yii::$app->request;

        $deviceId = Yii::$app->session['DEVICE_ID'];
        if ($request->getIsGet()) {

            $arrayRecordIds = $request->get('recordIds');

            $command = 'ELECTRONICQUEUE_TV_TALON_VOICE_COMMIT';

            $result = '';
            $errorMsg = '';

            echo $deviceId;

            if (isset($arrayRecordIds)) {
                $params = array(
                    array("NAME" => "P_TALON_ID", "VALUE" => $arrayRecordIds),
                    array("NAME" => "P_DEVICE_ID", "VALUE" => $deviceId));
            } else {
                $params = array(
                    array("NAME" => "P_TALON_ID", "VALUE" => ''),
                    array("NAME" => "P_DEVICE_ID", "VALUE" => $deviceId));
            }

            Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

            echo json_encode(array('data' => $result));
        }

    }

    public function actionMonitoringshanges()
    {
        $command = 'ELECTRONICQUEUE_IS_NEED_FORCE_REFRESH';
        $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => Yii::$app->session['DEVICE_ID']));
        $result = '';
        $errorMsg = '';
        Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

        echo json_encode(array('data' => $result[0], 'timeStamp' => date_timestamp_get(date_create())));
    }


    public function actionRendervideo()
    {


    }

    public function actionTest()
    {
        $command = 'ELECTRONICQUEUE_ADM_GET_QUEUE_TYPE_LIST';
        $params = array();
        $result = '';
        $errorMsg = '';
        Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);
    }
} 