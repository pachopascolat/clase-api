<?php

namespace app\controllers;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAxios()
    {
        return $this->render('axios');
    }

}
