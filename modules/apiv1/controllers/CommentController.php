<?php


namespace app\modules\apiv1\controllers;


use app\modules\apiv1\models\Comment;
use app\modules\apiv1\models\CommentSearch;
use app\modules\apiv1\models\PostSearch;
use yii\data\ActiveDataFilter;
use yii\rest\ActiveController;

class CommentController extends ActiveController
{
    public $modelClass = CommentSearch::class;


    public function actions()
    {
        $actions = parent::actions();
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['index']['dataFilter'] = ['class'=>ActiveDataFilter::class,'searchModel' => CommentSearch::class];
        return $actions;
    }

}
