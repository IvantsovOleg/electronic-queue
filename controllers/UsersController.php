?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Users;




class UsersController extends Controller {
    /**
     *
     */
    public function actionIndex(){
        $connection = \Yii::$app->db;

        $model = $connection->createCommand("SELECT * FROM `users`");
        $users = $model->queryOne();
        echo json_encode($users);
    }
}