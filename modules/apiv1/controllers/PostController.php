<?php


namespace app\modules\apiv1\controllers;


use app\models\PostSearch;
use app\models\User;
use app\modules\apiv1\models\Post;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class PostController extends ActiveController
{

    public $modelClass = Post::class;


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
//        $behaviors['corsFilter'] = [
//            'class' => \yii\filters\Cors::className(),
//        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;

//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::className(),
//            'authMethods' => [
//                [
//                    'class' => HttpBasicAuth::className(),
//                    'auth' => function ($username, $password) {
//                        $user = User::find()->where(['username' => $username])->one();
//                        if ($user!=null && $user->password == ($password)) {
//                            return $user;
//                        }
//                        return null;
//                    },
//                ],
////                HttpBasicAuth::class,
//                HttpBearerAuth::className(),
//                QueryParamAuth::className(),
//            ],
//        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new PostSearch();
        $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

        return $dataProvider;
    }

//    public function checkAccess($action, $model = null, $params = [])
//    {
//        if(in_array($action,['update','delete']) && $model->created_by !== \Yii::$app->user->id){
//            throw new ForbiddenHttpException('No tenes permiso para modificar este post');
//        }
////        parent::checkAccess($action, $model, $params); // TODO: Change the autogenerated stub
//    }


}
