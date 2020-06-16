<?php
/* @var $this yii\web\View */

//$this->registerCssFile("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js",['position'=>$this::POS_HEAD]);

?>

<div id="app" class="container">
    <h1>{{msg}}</h1>
    <!-- Button trigger modal -->
    <div>
        <div class="col-6 m-auto pb-3">
            <form action="">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input v-model="post.title" type="text" name="title" id="title" class="form-control" placeholder="Ingrese el titulo del post" aria-describedby="helpId">
                    <small id="titlehelpId" class="text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <input v-model="post.body" type="text" name="body" id="body" class="form-control" placeholder="Ingrese el cuerpo del Post" aria-describedby="helpId">
                    <small id="bodyhelpId" class="text-muted"></small>
                </div>
                <button v-if="isNewRecord"  @click="addPost()" type="button" class="btn btn-primary m-3">Crear</button>
                <button v-if="!isNewRecord"  @click="post={}" type="button" class="btn btn-success m-3">Nuevo</button>
                <button v-if="!isNewRecord" @click="updatePost(post.key)" type="button" class="btn btn-primary m-3">Actualizar</button>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Body</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(post,key) in posts" v-bind:key="post.id">
            <td scope="row">{{post.id}}</td>
            <td>{{post.title}}</td>
            <td>{{post.body}}</td>
            <td>
                <button type="button" class="btn btn-primary">ver Comments</button>
            </td>
            <td>
                <button v-on:click="editPost(key)" type="button" class="btn btn-warning">Editar</button>
            </td>
            <td>
                <button v-on:click="deletePost(key)" type="button" class="btn btn-danger">Borrar</button>
            </td>
        </tr>
        </tbody>
    </table>

</div>

<script>

    var app = new Vue({

        el: "#app",
        data: function () {
            return {
                msg: "Posts",
                posts: [],
                post:{},
                isNewRecord:true,
            }
        },
        mounted() {
            this.getPosts();
        },
        methods: {
            getPosts: function(){
                this.posts = [
                    {'id':1,'title':'Post nro1','body':'body del post nro 1'},
                    {'id':2,'title':'Post nro2','body':'body del post nro 2'},
                    {'id':3,'title':'Post nro3','body':'body del post nro 3'},
                    {'id':4,'title':'Post nro4','body':'body del post nro 4'},
                ];
            },
            deletePost: function(id){
                this.posts.splice(id, 1);
            },
            editPost: function (key) {
                this.post = Object.assign({},this.posts[key]);
                this.post.key = key;
                this.isNewRecord = false;

            },
            addPost: function(){
                this.post.id = this.posts.length +1;
                this.posts.unshift(this.post);
                this.post = {};
            },
            updatePost: function (key) {
                this.posts[key] = this.post;
                this.post = {};
                this.isNewRecord = true;
            }

        }

    })

</script>
