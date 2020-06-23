<?php

namespace app\modules\apiv1\models;


class Comment extends \app\models\Comment
{



public function fields()
{
    return ['id','title','body','post_id','post'];
}



public function getPostitle(){
    return $this->post->title??'';
}


}
