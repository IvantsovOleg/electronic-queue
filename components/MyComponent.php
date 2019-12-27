<?php
/**
 * Created by PhpStorm.
 * User: anciferov
 * Date: 08.06.2015
 * Time: 17:12
 */
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{
    public function welcome()
    {
        echo "Hello..Welcome to MyComponent";
    }

}