<?php


namespace app\modules\apiv1\controllers;


use app\models\Alumno;
use yii\rest\ActiveController;

class AlumnoController extends ActiveController
{
    public $modelClass = Alumno::class;

}
