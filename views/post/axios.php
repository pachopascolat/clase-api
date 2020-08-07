<?php
/* @var $this yii\web\View */

$this->registerCssFile("//unpkg.com/bootstrap/dist/css/bootstrap.min.css",['position'=>$this::POS_HEAD]);
$this->registerCssFile("//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css",['position'=>$this::POS_HEAD]);
//$this->registerCssFile("//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver",['position'=>$this::POS_HEAD]);

$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js",['position'=>$this::POS_HEAD]);
//$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js",['position'=>$this::POS_HEAD]);

echo $this->render('/components/PostCrud');
?>



<div id="app">
    <post
            v-bind:model="model"
            v-bind:modelname="modelname"
            v-bind:fields="fields"
    ></post>
</div>

<script>

    var app = new Vue({
        el: "#app",
        components:{
            post: Post,
        },
        data:{
            model: <?= json_encode($model->getAttributes()) ?>,
            //relates: <?//= json_encode($model->getRelationData()) ?>//,
            //rules: <?//= json_encode($model->rules()) ?>//,
            fields: ['id','title','body'] , //poner en un array los campos que queres
            modelname: <?= json_encode($model::tableName())?>,
        }
    })

</script>
