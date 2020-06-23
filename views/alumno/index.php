<?php
/* @var $this yii\web\View */

$this->registerCssFile("//unpkg.com/bootstrap/dist/css/bootstrap.min.css",['position'=>$this::POS_HEAD]);
$this->registerCssFile("//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css",['position'=>$this::POS_HEAD]);
//$this->registerCssFile("//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver",['position'=>$this::POS_HEAD]);

$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js",['position'=>$this::POS_HEAD]);
//$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js",['position'=>$this::POS_HEAD]);

echo $this->render('/components/ModelCrud');
?>



<div id="app">
    <crud
        v-bind:model="model"
        v-bind:modelname="modelname"
    ></crud>
</div>

<script>

    var app = new Vue({
        el: "#app",
        components:{
            crud: Crud,
        },
        data:{
            model: <?= json_encode($model->getAttributes()) ?>,
            //rules: <?//= json_encode($model->getRelatedRecords()) ?>//,
            //relations: <?//= json_encode($model->rules()) ?>//,
            fields: null, // poner en un array los campos que queres
            modelname: <?= json_encode($model::tableName())?>,
        }
    })

</script>
