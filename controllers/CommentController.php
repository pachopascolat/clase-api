<?php

namespace app\controllers;

use app\models\Post;
use app\modules\apiv1\models\Comment;

class CommentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAxios()
    {
        $this->layout = 'bootstrap4';
        $model = new Comment();
        return $this->render('axios',[
            'model'=>$model,
        ]);
    }

}
