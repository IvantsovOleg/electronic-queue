<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;
use DirectoryIterator;

class SiteController extends Controller
{


    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
*/
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()

    {

        /*
                foreach (new DirectoryIterator('../moodle') as $fileInfo) {
                    if($fileInfo->isDot()) continue;
                    echo $fileInfo->getFilename() . "<br>\n";
                }*/


        /* if (true) {
             $session = new Session;
             $session->open();
             Yii::$app->request->isGetget('tvcode')
             $tvCode = Yii::$app->request->get('tvcode');
             if (isset($tvCode)) {
                 Yii::$app->session['tvCode'] = $tvCode;
             } else {
                 Yii::$app->session['tvCode'] = '';
             }


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
             }
             return $this->redirect(['getnumber']);


         } else {
             echo 'Вы не заполнили значение параметра "tvcode" идентифицируюущего устройство, заполните его в url строке браузера "monitorqueue/index&tvcode==НУЖНОЕ ЗНАЧЕНИЕ" (тестовое значение TV_REG_1)';
         }*/


        $this->redirect('index.php?r=site/getnumber');

    }

    public function actionGetnumber()
    {
        Yii::$app->cmonitor->deleteAllOldfiles();

        $command = "ELECTRONICQUEUE_GET_QUEUES_LIST";
        $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => '2'));
        $result = '';

        Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);

        Yii::$app->cxml->handlerErros($errorMsg);

        $connection = \Yii::$app->db;
        $model = $connection->createCommand('SELECT  `NAME` ,  `INDEX_MES` FROM  `lpu`');
        $lpu_information = $model->queryAll();

        $lpuName = $lpu_information[0]['NAME'];
        $lpuInstruction = $lpu_information[0]['INDEX_MES'];
        return $this->render('getnumber', ['result' => $result, 'lpuInstruction' => $lpuInstruction]);


    }

    public function actionPrintnumber()
    {
        if (isset($_GET)) {
            $result = $_GET['keyid'];
	    if (isset($_GET['dopinfo']))
	    {
		    $dopinfo = $_GET['dopinfo'];
	    } else {
                    $dopinfo = '';
            }
            if (isset($_GET['namequeue'])) {
                if ($_GET['namequeue'] == 'xxx') {
                    $namequeue = Yii::$app->session['namequeue'];
                } else {
                    $namequeue = str_replace(" ", "&nbsp", $_GET['namequeue']);
                }

            } else {
                $namequeue = '';
            }

        }

        $command = "ELECTRONICQUEUE_GET_NEW_TALON";
        $params = array(array("NAME" => "P_DEVICE_ID", "VALUE" => ''), array("NAME" => "P_QUEUE_ID", "VALUE" => $result));
        Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);


        return $this->render('printnumber', ['result' => $result, 'namequeue' => $namequeue, 'dopinfo' => $dopinfo]);
    }

    public function actionHandlerError()
    {

        return $this->render('error');
    }

    public function actionAuthpatient()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            Yii::$app->session['namequeue'] = $request->get('namequeue');
            $keyid = $request->get('keyid');

            $namequeue = 'xxx';
            $namequeue = str_replace(" ", "&nbsp", $namequeue);
            return $this->render('authpatient', ['namequeue' => $namequeue, 'keyid' => $keyid]);
        }
    }

    public function actionAjaxauthpatient()
    {
        $request = Yii::$app->request;

        // echo 'test';

        // print_r($request->get());
        //print_r($request->post('userdata'));
        if ($request->isPost) {
            //  $userdata = ;
            $userdata = $request->post('userdata'); //explode(",", $request->post('userdata'));

            if (!isset($userdata[2])) {
                $directionNum = '';
            } else {
                $directionNum = $userdata[2];
            }

            $namequeue = $request->post('namequeue');
            // $namequeue = str_replace(" ", "&nbsp",$namequeue);
            /*if (isset($_GET['namequeue'])) {
                $namequeue = str_replace(" ", "&nbsp", $_GET['namequeue']);
            } else {
                $namequeue = '';
            }*/


            $command = "ELECTRONICQUEUE_GET_NEW_TALON_WITH_AUTH";
            $params = array(
                array("NAME" => "P_DEVICE_ID", "VALUE" => 1),
                array("NAME" => "P_QUEUE_ID", "VALUE" => 1),
                array("NAME" => "P_DIRECT_NUM", "VALUE" => $directionNum),
                array("NAME" => "P_FIO", "VALUE" => $userdata[0]),
                array("NAME" => "P_BIRTHDATE", "VALUE" => $userdata[1])
            );

            Yii::$app->cxml->makeRequest($command, $params, $result, $errorMsg);
            if ((int)$result[0]['TALON_ID'] > 0) {
                Yii::$app->session['resultAfterAuth'] = $result;
            }
            echo json_encode(array('data' => $result));

            Yii::$app->cxml->handlerErros($errorMsg);

            // print_r($result);
            /*if ((int)$result[0]['TALON_ID'] < 0) {
                if (isset($result[0]['MESSAGE'])) {
                    $messege = $result[0]['MESSAGE'];
                    return $this->render('printnumber', ['messege' => $messege]);
                }
            } else {
                $messege = $result[0]['MESSAGE'];
                return $this->render('printnumber', ['result' => $result, 'namequeue' => $namequeue, 'messege' => $messege]);
            }*/
            /*if(!$result){
                $result = '';
                echo 'пациент не найден';
            }else{
                return $this->render('printnumber', ['result' => $result,'namequeue' => $namequeue]);
            }*/

        }

    }

    public function actionRenderafterauth()
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            $result = Yii::$app->session['resultAfterAuth'];
            $namequeue =Yii::$app->session['namequeue'];

            return $this->render('printnumber', ['result' => $result, 'namequeue' => $namequeue]);

        }


    }


}
