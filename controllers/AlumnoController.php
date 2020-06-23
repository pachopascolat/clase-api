<?php


namespace app\controllers;


use app\models\Alumno;
use yii\web\Controller;

class AlumnoController extends Controller
{
    public function actionIndex(){
        $this->layout = 'bootstrap4';
        $model = new Alumno();
        return $this->render('index',['model'=>$model]);
    }

}
