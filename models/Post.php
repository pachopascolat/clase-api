<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Post extends \yii\db\ActiveRecord
{



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return
            [
                TimestampBehavior::class,
                [
                    'class'=> BlameableBehavior::class,
                ]
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','body'],'required'],
//            [['body'], 'integer'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
//            'created_by' => 'Created By',
//            'updated_by' => 'Updated By',
        ];
    }


    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    public function getCreator(){
        return $this->hasOne(User::className(),['id'=>'created_by']);
    }

    public function getCreatorName(){
        return $this->creator->username;
    }


    public function getRelationData() {
        $ARMethods = get_class_methods('\yii\db\ActiveRecord');
        $modelMethods = get_class_methods('\yii\base\Model');
        $reflection = new \ReflectionClass($this);
        $i = 0;
        $stack = [];
        /* @var $method \ReflectionMethod */
        foreach ($reflection->getMethods() as $method) {
            if (in_array($method->name, $ARMethods) || in_array($method->name, $modelMethods)) {
                continue;
            }
            if($method->name === 'bindModels')  {continue;}
            if($method->name === 'attachBehaviorInternal')  {continue;}
            if($method->name === 'getRelationData')  {continue;}
            try {
                $rel = call_user_func(array($this,$method->name));
                if($rel instanceof ActiveQuery){
                    $stack[$i]['name'] = lcfirst(str_replace('get', '', $method->name));
                    $stack[$i]['method'] = $method->name;
                    $stack[$i]['ismultiple'] = $rel->multiple;
                    $i++;
                }
            } catch (\yii\base\ErrorException $exc) {
//
            }
        }
        return $stack;
    }


}




