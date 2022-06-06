<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">Add</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Registered At</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categorie in categories" :key="categorie.id">
                                    <td>{{categorie.id}}</td>
                                    <td>{{categorie.category_name|upText}}</td>
                                    <td>{{categorie.created_at}}</td>
                                    <td>
                                        <a href="" @click.prevent="editModal(categorie)"><i class="fa fa-edit"></i></a>/
                                        <!--<button type="submit" @click="deleteCategory(categorie.id)"><i class="fa fa-trash"></i></button>-->
                                        <a href="" @click.prevent="deleteCategory(categorie.id)"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
          </div>
        </div>
          <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Categorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? UpdateCategory() : createCategory()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="category_name">Category Name</label>
                                            <input v-model="form.category_name" type="text"  name="category_name" 
                                            class="form-control" :class="{'is-invalid' :form.errors.has('category_name')}">
                                            <has-error :form="form" field="category_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                    </div>
                            </form>
                    </div>
                </div>
            </div>
        
    </div>
</template>

<script>
    export default {
        data(){
            return{
                editmode:false,
                categories:[],
                form:new Form({
                    id:'',
                    category_name:''
                })
            }
        },
        methods:{
            UpdateCategory()
            {
                //console.log('editing data')
                this.$Progress.start();
                this.form.put('api/category/'+this.form.id)
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Swal.fire(
                                    'Updated!',
                                    'Your category has been Updated.',
                                    'success'
                                        )
                     this.$Progress.finish();
                }).catch(()=>{
                this.$Progress.fail();
                })
            },
            editModal(categorie)
            {
                this.editmode=true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(categorie);
            },
            newModal()
            {
                this.editmode=false;
                this.form.reset();
                $('#addNew').modal('show');
            },
             deleteCategory(id)
                {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.form.delete('api/category/'+id).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Your category has been deleted.',
                                    'success'
                                        )
                            Fire.$emit('AfterCreate')
                            }).catch(()=>{
                                Swal("Failed!!","There was something wrong.","warning")
                            })
                        }//fin if
                    }) //fin
                },
            loadCategories(){
                axios.get("api/category").then(({data})=>{
                    this.categories=data.data
                }).catch(err=>{

                })
            },
            createCategory(){
                    this.$Progress.start();
                    this.form.post('api/category').then(res=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Category created successfully'
                    })
                    this.$Progress.finish();
                }).catch(err=>{
                    this.$Progress.fail()
                });
            }
        },
        created() {
            this.loadCategories();
            Fire.$on('AfterCreate',()=>{
                this.loadCategories();
            })
        }
    }
</script>
