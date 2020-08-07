<?php


namespace app\modules\apiv1\controllers;


use app\models\Categoria;
use yii\rest\ActiveController;
use yii\rest\Controller;

class CategoriaController extends ActiveController
{
    public $modelClass = Categoria::class;

}
