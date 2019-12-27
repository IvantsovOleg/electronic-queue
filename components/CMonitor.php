<?php
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use DirectoryIterator;


class CMonitor extends Component
{


    public static function generateVoiceOneTalon($voiceStringWithDelimiter, $host, $finalFileToPage)
    {
        $activeTalonArrayVoice = explode(',', $voiceStringWithDelimiter);
        $firstSimbolCode = strtolower($activeTalonArrayVoice[0]);

        $second_file = file_get_contents($host . '/exp/nomer.mp3');
        $first_file = file_get_contents($host . '/exp/' . $firstSimbolCode . '.mp3');
        file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $second_file . $first_file);

        for ($a = 1; $a < count($activeTalonArrayVoice); $a++) {

           /* $testVar = $activeTalonArrayVoice[$a];*/
            if (!is_string($activeTalonArrayVoice[$a])) {
                $testVar = (int)$activeTalonArrayVoice[$a];

            } else {
                $testVar = $activeTalonArrayVoice[$a];
            }

            $first_file = file_get_contents($host . '/exp/voice/' . $finalFileToPage . '.mp3');
            $second_file = file_get_contents($host . '/exp/' . $testVar . '.mp3');
            file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $first_file . $second_file);
        }
        $first_file = file_get_contents($host . '/exp/voice/' . $finalFileToPage . '.mp3');
        $second_file = file_get_contents($host . '/exp/silence.mp3');
        file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $first_file . $second_file);


    }

    public static function generateVoiceSomeTalon($voiceStringWithDelimiter, $host, $finalFileToPage)
    {

        $activeTalonArrayVoice = explode(',', $voiceStringWithDelimiter);

        $firstSimbolCode = strtolower($activeTalonArrayVoice[0]);

        $second_file = file_get_contents($host . '/exp/nomer.mp3');
        file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $second_file);

        for ($a = 0; $a < count($activeTalonArrayVoice); $a++) {
            $testVar = $activeTalonArrayVoice[$a];
            if (!is_string($activeTalonArrayVoice[$a])) {
                $testVar = (int)$activeTalonArrayVoice[$a];

            } else {
                $testVar = $activeTalonArrayVoice[$a];
            }
            $first_file = file_get_contents($host . '/exp/voice/' . $finalFileToPage . '.mp3');
            $second_file = file_get_contents($host . '/exp/' . $testVar . '.mp3');
            file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $first_file . $second_file);
        }

        $first_file = file_get_contents($host . '/exp/voice/' . $finalFileToPage . '.mp3');
        $second_file = file_get_contents($host . '/exp/silence.mp3');
        file_put_contents('../web/exp/voice/' . $finalFileToPage . '.mp3', $first_file . $second_file);


    }


    public static function bondingMp3TalonFiles($voiceStringWithDelimiter, $host, $finalFileToPage)
    {
        if (strpos($voiceStringWithDelimiter, '#')) {
            $StringWithDelimiter = '';
            $activeTalons = explode('#', $voiceStringWithDelimiter);
            foreach ($activeTalons as $key => $value) {
                if ($StringWithDelimiter == '') {
                    $StringWithDelimiter .= $value;
                } else {
                    $StringWithDelimiter .= ',' . $value;
                }
            }
            self::generateVoiceSomeTalon($StringWithDelimiter, $host, $finalFileToPage);
        } else {
            self::generateVoiceOneTalon($voiceStringWithDelimiter, $host, $finalFileToPage);
        }
        $mp3file = new CAudiofile('../web/exp/voice/' . $finalFileToPage . '.mp3');

       // echo $mp3file->getDurationEstimate();

        return $mp3file->getDurationEstimate();
    }


    public static function comliteArrayToDoctorMonitor($resultTvTalon)
    {

        $roomArray = [];
        for ($b = 0; $b < count($resultTvTalon); $b++) {
            if (!in_array($resultTvTalon[$b]['ROOM'], $roomArray)) {
                $roomArray[$resultTvTalon[$b]['ROOM']] = [];
                $roomArray[$resultTvTalon[$b]['ROOM']]['room'] = $resultTvTalon[$b]['ROOM'];
            }
        }
        $allPassiveForThisRoom = [];
        $stringNeedToVoice = '';
        foreach ($roomArray as $key => $value) {
            for ($c = 0; $c < count($resultTvTalon); $c++) {
                if ($key == $resultTvTalon[$c]['ROOM']) {
                    $roomArray[$key]['RECORD_ID'] = $resultTvTalon[$c]['RECORD_ID'];

                    if (isset($resultTvTalon[$c]['IS_NEED_VOICE'])) {
                        if (!isset($roomArray[$key]['IS_NEED_VOICE'])) {
                            $roomArray[$key]['IS_NEED_VOICE'] = '';
                        }
                        if ($resultTvTalon[$c]['IS_NEED_VOICE'] == 1) {

                            $roomArray[$key]['IS_NEED_VOICE'] = $resultTvTalon[$c]['IS_NEED_VOICE'];

                            if (isset($resultTvTalon[$c]['RECORD_ID'])) {
                                if (!isset($roomArray[$key]['RECORD_IDS'])) {
                                    $roomArray[$key]['RECORD_IDS'] = $resultTvTalon[$c]['RECORD_ID'];
                                } else {
                                    $roomArray[$key]['RECORD_IDS'] .= ',' . $resultTvTalon[$c]['RECORD_ID'];
                                }


                            }
                            if (isset($resultTvTalon[$c]['VOICE'])) {
                                if (!isset($roomArray[$key]['VOICE'])) {
                                    $roomArray[$key]['VOICE'] = $resultTvTalon[$c]['VOICE'];
                                } else {
                                    $roomArray[$key]['VOICE'] .= '#' . $resultTvTalon[$c]['VOICE'];
                                }


                            }
                        }
                    }




                    if ((int)$resultTvTalon[$c]['STATUS'] === 1) {
                        if (!isset($roomArray[$key]['stringactive'])) {
                            $roomArray[$key]['stringactive'] = '';
                            if (isset($resultTvTalon[$c]['CODE'])) {
                                $roomArray[$key]['stringactive'] .= $resultTvTalon[$c]['CODE'];
                            }
                        }

                    }

                    if ((int)$resultTvTalon[$c]['STATUS'] !== 1) {
                        if (isset($roomArray[$key]['stringpas'])) {
                            $roomArray[$key]['stringpas'] .= ',' . $resultTvTalon[$c]['CODE'];
                        } else {
                            $roomArray[$key]['stringpas'] = '';
                            $roomArray[$key]['stringpas'] .= $resultTvTalon[$c]['CODE'];
                        }

                    }
                }
            }
        }
        return $roomArray;

    }

    public static function setConfigPlayList($arraySettingsToRenderMonitor)
    {
        $commandTalon = null;
        $commandRuningLine = null;
        $commandVideo = null;

        for ($i = (count($arraySettingsToRenderMonitor) - 1); $i >= 0; $i--) {

            switch ((int)$arraySettingsToRenderMonitor[$i]['ITEM_TYPE']) {
                case 1:
                    $commandTalon['list'] = $arraySettingsToRenderMonitor[$i]['QUERY'];
                    $commandTalon['duration'] = $arraySettingsToRenderMonitor[$i]['DURATION'];
                    break;
                case 2:
                    $commandRuningLine['text'] = $arraySettingsToRenderMonitor[$i]['QUERY'];
                    $commandRuningLine['duration'] = $arraySettingsToRenderMonitor[$i]['DURATION'];
                    break;
                case 3:
                    $commandVideo['video'] = $arraySettingsToRenderMonitor[$i]['QUERY'];
                    $commandVideo['duration'] = $arraySettingsToRenderMonitor[$i]['DURATION'];
                    break;
                default:
                    echo "Возникла ошибка при конфигурации обрудования, проверьте подключение к xml северу и db";
            }

        }


        return array('commandTalonList' => $commandTalon, 'commandRuningLine' => $commandRuningLine, 'commandVideo' => $commandVideo);

    }

    public static function deleteAllOldfiles()
    {
        $directoryDelete = Yii::getAlias('@app') . '/web/exp/voice/';

        $day = 21600;

        $now = time();

        $test = new DirectoryIterator(Yii::getAlias('@app') . '/web/exp/voice');

        foreach ($test as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            if (($now - $fileInfo->getMTime()) > $day) {
                unlink($directoryDelete . $fileInfo->current());
            }
        }
    }

    public static function counterTest()
    {
        // Имя файла, в котором хранится счетчик
        $file_counter = "../web/exp/counter.txt";

// Читаем текущее значение счетчика
        if (file_exists($file_counter)) {
            $fp = fopen($file_counter, "r+");
            $counter = fread($fp, filesize($file_counter));
            fclose($fp);
        } else {
            $counter = 0;
        }

// Увеличиваем счетчик на единицу
        $counter++;

// Сохраняем обновленное значение счетчика
        $fp = fopen($file_counter, "w+");
        fwrite($fp, $counter);
        fclose($fp);

// Выводим значение счетчика на печать
        return $counter;

    }


}