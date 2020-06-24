<script type="text/x-template" id="crud-template">
    <div class="container">
        <h1 class="text-capitalize">{{modelname}}</h1>
        <!-- Button trigger modal -->
        <b-modal v-model="modalShow"  id="modal-1" title="Nuevo Item">
            <div>
                <form action="">
                    <div v-if="i>0" v-for="(field,i) in modelfields" class="form-group">
                        <label :for="field">{{field}}</label>
                        <input v-model="activemodel[field]" type="text" :name="field" :id="field" class="form-control" :placeholder="'Ingrese el '+ field " aria-describedby="helpId">
                        <span class="text-danger" v-if="errors[field]" >{{errors[field]}}</span>
                    </div>
                </form>
            </div>
            <template v-slot:modal-footer="{ ok, cancel, hide }">
                <button v-if="isNewRecord"  @click="addModel()" type="button" class="btn btn-primary m-3">Crear</button>
                <button v-if="!isNewRecord"  @click="activemodel={}" type="button" class="btn btn-success m-3">Nuevo</button>
                <button v-if="!isNewRecord" @click="updateModel(activemodel[modelfields[0]])" type="button" class="btn btn-primary m-3">Actualizar</button>
            </template>
        </b-modal>

        <p>
            <b-button  v-on:click="modalShow=true">New</b-button>
        </p>
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
                <th v-for="field in modelfields">{{field}}</th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <td></td>
                <td v-for="field in modelfields">
                    <input v-on:change="getModels()" class="form-control" v-model="filter[field]">
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(model,key) in models" v-bind:key="model[modelfields[0]]">
                <td>{{key+1}}</td>
                <td v-for="field in modelfields">{{model[field]}}</td>
                <td>
                    <button v-b-modal.modal-1 v-on:click="editModel(key)" type="button" class="btn btn-outline-warning">Editar</button>
                </td>
                <td>
                    <button v-on:click="deleteModel(model[modelfields[0]])" type="button" class="btn btn-danger">Borrar</button>
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
</script>
<script>

    const Crud = {
        name: 'crud',
        template: '#crud-template',
        props: {
            modelname: String,
            model : Object,
            fields: {
                type:Array,
                // default: Object.keys(model),
            },
        },
        mounted() {
            this.getModels();
        },
        watch:{
            currentPage: function() {
                this.getModels();
            }
        },
        data : function(){
            return {
                modalShow: false,
                modelfields: this.fields??Object.keys(this.model),
                currentPage: 1,
                pagination:{},
                filter:{},
                errors: {},
                models: [],
                activemodel:{},
                isNewRecord:true,
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
            // normalizeFilters(){
            //     var filters = {};
            //     for(var i in this.filter ){
            //         if(this.filter[i]) {
            //             filters['filter[' + i + ']'] = this.filter[i];
            //         }
            //     }
            //     return filters;
            // },
            getModels: function(){
                var self = this;
                self.errors = {};
                // var filters = self.normalizeFilters();
                axios.get('/apiv1/'+self.modelname+'?page='+self.currentPage,{params:self.filter})
                    .then(function (response) {
                        // handle success
                        // console.log(response.data);
                        self.pagination.total = response.headers['x-pagination-total-count'];
                        self.pagination.totalPages = response.headers['x-pagination-page-count'];
                        self.pagination.perPage = response.headers['x-pagination-per-page'];
                        self.models = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            deleteModel: function(id){
                var self = this;
                axios.delete('/apiv1/'+self.modelname+'/'+id,{})
                    .then(function (response) {
                        // handle success
                        self.getModels();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            editModel: function (key) {
                this.activemodel = Object.assign({},this.models[key]);
                // this.activemodel.key = key;
                this.isNewRecord = false;
            },
            addModel: function(){
                var self = this;
                axios.post('/apiv1/'+self.modelname,self.activemodel)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getModels()
                        self.activemodel = {};
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
            updateModel: function (key) {
                var self = this;
                axios.patch('/apiv1/'+self.modelname+'/'+key,self.activemodel)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getModels();
                        self.activemodel = {};
                        self.isNewRecord = true;
                        self.modalShow = false;
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
    }
</script>
