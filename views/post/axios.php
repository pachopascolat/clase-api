<?php
/* @var $this yii\web\View */

$this->registerCssFile("//unpkg.com/bootstrap/dist/css/bootstrap.min.css",['position'=>$this::POS_HEAD]);
$this->registerCssFile("//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css",['position'=>$this::POS_HEAD]);
//$this->registerCssFile("//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver",['position'=>$this::POS_HEAD]);

$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js",['position'=>$this::POS_HEAD]);
//$this->registerJsFile("https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js",['position'=>$this::POS_HEAD]);

?>

<div id="app" class="container p-5">
    <h1>{{msg}}</h1>
    <!-- Button trigger modal -->
    <div>
        <div class="col-6 m-auto pb-3">
            <form action="">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input v-model="post.title" type="text" name="title" id="title" class="form-control" placeholder="Ingrese el titulo del post" aria-describedby="helpId">
                    <small  id="titlehelpId" class="text-muted"></small>
                    <span class="text-danger" v-if="errors.title" >{{errors.title}}</span>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <input v-model="post.body" type="text" name="body" id="body" class="form-control" placeholder="Ingrese el cuerpo del Post" aria-describedby="helpId">
                    <small id="bodyhelpId" class="text-muted"></small>
                    <span class="text-danger"  v-if="errors.body">{{errors.body}}</span>
                </div>
                <button v-if="isNewRecord"  @click="addPost()" type="button" class="btn btn-primary m-3">Crear</button>
                <button v-if="!isNewRecord"  @click="post={}" type="button" class="btn btn-success m-3">Nuevo</button>
                <button v-if="!isNewRecord" @click="updatePost(post.id)" type="button" class="btn btn-primary m-3">Actualizar</button>
            </form>
        </div>
    </div>

    <b-pagination
            v-model="currentPage"
            :total-rows="pagination.total"
            :per-page="pagination.perPage"
            aria-controls="my-table"
    ></b-pagination>


    <table class="table" id="my-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Title</th>
            <th>Body</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td>
                <input v-on:change="getPosts()" class="form-control" v-model="filter.id">
            </td>
            <td>
                <input v-on:change="getPosts()" class="form-control" v-model="filter.title">
            </td>
            <td>
                <input v-on:change="getPosts()" class="form-control" v-model="filter.body">
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(post,key) in posts" v-bind:key="post.id">
            <td>{{key+1}}</td>
            <td scope="row">{{post.id}}</td>
            <td>{{post.title}}</td>
            <td>{{post.body}}</td>
            <td>
                <button type="button" class="btn btn-outline-primary">Comments</button>
            </td>
            <td>
                <button v-on:click="editPost(key)" type="button" class="btn btn-outline-warning">Editar</button>
            </td>
            <td>
                <button v-on:click="deletePost(post.id)" type="button" class="btn btn-danger">Borrar</button>
            </td>
        </tr>
        </tbody>
    </table>
    <b-pagination
            v-model="currentPage"
            :total-rows.number="pagination.total"
            :per-page.number="pagination.perPage"
            aria-controls="my-table"
    ></b-pagination>

</div>

<script>

    var username = 'pacho';
    var password = '123456';
    var credentials = btoa(username + ':' + password);
    var basicAuth = 'Basic ' + credentials;

    const
        headers = { Authorization: `Bearer pacho-token` }
        // headers: { Authorization: + basicAuth }
    ;

    var app = new Vue({
        el: "#app",
        data: function () {
            return {
                currentPage: 1,
                pagination:{},
                filter:{},
                errors: {},
                msg: "Posts",
                posts: [],
                post:{},
                isNewRecord:true,
            }
        },
        mounted() {
            this.getPosts();
        },
        watch:{
            currentPage: function () {
                this.getPosts();
            }
        },
        methods: {
            normalizeErrors: function(errors){
              var allErrors = {};
              for(var i = 0 ; i < errors.length; i++ ){
                  allErrors[errors[i].field] = errors[i].message;
              }
              return allErrors;
            },
            getPosts: function(){
                var self = this;
                axios.get('/apiv1/posts?page='+self.currentPage,{params:self.filter})
                    .then(function (response) {
                        // handle success
                        // console.log(response.data);
                        self.pagination.total = response.headers['x-pagination-total-count'];
                        self.pagination.totalPages = response.headers['x-pagination-page-count'];
                        self.pagination.perPage = response.headers['x-pagination-per-page'];
                        self.posts = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            deletePost: function(id){
                var self = this;
                axios.delete('/apiv1/posts/'+id,{})
                    .then(function (response) {
                        // handle success
                        console.log("borre post id: "+ id);
                        console.log(response.data);
                        self.getPosts();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            editPost: function (key) {
                this.post = Object.assign({},this.posts[key]);
                this.post.key = key;
                this.isNewRecord = false;
            },
            addPost: function(){
                var self = this;
                // const params = new URLSearchParams();
                // params.append('title', self.post.title);
                // params.append('body', self.post.body);
                axios.post('/apiv1/posts',self.post)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getPosts()
                        // self.posts.unshift(response.data);
                        self.post = {};
                    })
                    .catch(function (error) {
                        // var errors = error.response.data;
                        console.log(error.response.data);
                        self.errors = self.normalizeErrors(error.response.data);
                        // handle error
                        console.log(self.errors);

                    })
                    .then(function () {
                        // always executed
                    });
            },
            updatePost: function (key) {
                var self = this;
                // const params = new URLSearchParams();
                // params.append('title', self.post.title);
                // params.append('body', self.post.body);
                axios.patch('/apiv1/posts/'+key,self.post)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getPosts();
                        self.post = {};
                        self.isNewRecord = true;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        self.errors = self.normalizeErrors(error.response.data);
                    })
                    .then(function () {
                        // always executed
                    });

            }

        }

    })

</script>
