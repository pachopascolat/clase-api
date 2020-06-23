<?php

namespace app\controllers;

use app\modules\apiv1\models\Post;
use yii\rest\Serializer;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAxios()
    {
        $this->layout = 'bootstrap4';
        $model = new Post();
        return $this->render('axios',[
            'model'=>$model,
        ]);
    }

}
