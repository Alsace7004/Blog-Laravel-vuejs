<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post Table</h3>

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
                                <th>User</th>
                                <th>title</th>
                                <th>Description</th>
                                <th>Photo</th>
                                <th>Created_at</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in posts" :key="post.id">
                                    <td>{{post.id}}</td>
                                    <td>{{post.user_id}}</td>
                                    <td>{{post.title}}</td>
                                    <td>{{post.description}}</td>
                                    <td><img :src="ourImage(post.photo)" alt="" width="40" height="50"></td>
                                    <td>{{post.created_at}}</td>
                                    <td>
                                        <a href="" @click.prevent="editModal(post)"><i class="fa fa-edit"></i></a>/
                                        <!--<button type="submit" @click="deleteCategory(categorie.id)"><i class="fa fa-trash"></i></button>-->
                                        <a href="" @click.prevent="deletePost(post.id)"><i class="fa fa-trash"></i></a>
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
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? UpdatePost() : createPost()" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input v-model="form.title" type="text"  name="title" 
                                            class="form-control" :class="{'is-invalid' :form.errors.has('title')}">
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                         <div class="form-group">
                                            <label for="description">Description</label>
                                            <input v-model="form.description" type="text"  name="description" 
                                            class="form-control" :class="{'is-invalid' :form.errors.has('description')}">
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            <input  type="file" @change="changePhoto($event)"  name="photo"
                                            class="form-control" :class="{'is-invalid' :form.errors.has('photo')}">
                                            <img v-show="!editmode" :src="form.photo" alt="" width="80" height="80">
                                            <img v-show="editmode" :src="updateImage()" alt="" width="80" height="80">
                                            <has-error :form="form" field="photo"></has-error>
                                        </div>
                                        
                                        <input type="hidden" name="user_id" v-model="form.user_id">
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
                posts:[],
                users:[],
                form:new Form({
                    id:'',
                    user_id:'1',
                    title:'',
                    description:'',
                    photo:'',
                   
                })
            }
        },
       
        methods:{
        /*create(){
            axios.post('api/post')
                .then(({response})=> {
                    this.posts = response.data.posts
                    // console.log(response.data.auteurs)
                })
                .catch(err=> {
                    console.log(err.response.data)
                })

        },*/
            updateImage()
            {
                let img= this.form.photo;
                if(img.length>100)
                {
                    return this.form.photo
                }
                else{
                    return 'uploadimage/'+this.form.photo;
                }
            },
            ourImage(img)
            {   
                return "uploadimage/"+img;
            },
            changePhoto(event)
            {
               let file = event.target.files[0];
               console.log(file);
               if(file.size>1048576)//1048576
               {
                   Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
               }
               else
               {
                        let reader = new FileReader();
                        reader.onloadend = (event)=>{
                        // console.log('RESULT',reader.result)
                        this.form.photo = event.target.result;
                        }
                        reader.readAsDataURL(file);
               }
               
            },
            UpdatePost()
            {
                //console.log('editing data')
                this.$Progress.start();
                this.form.put('api/post/'+this.form.id)
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Swal.fire(
                                    'Updated!',
                                    'Your post has been Updated.',
                                    'success'
                                        )
                     this.$Progress.finish();
                }).catch(()=>{
                this.$Progress.fail();
                })
            },
            editModal(post)
            {
                this.editmode=true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(post);
            },
            newModal()
            {
                this.editmode=false;
                this.form.reset();
                $('#addNew').modal('show');
            },
             deletePost(id)
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
                            this.form.delete('api/post/'+id).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Your post has been deleted.',
                                    'success'
                                        )
                            Fire.$emit('AfterCreate')
                            }).catch(()=>{
                                Swal("Failed!!","There was something wrong.","warning")
                            })
                        }//fin if
                    }) //fin
                },
            loadPosts(){
                axios.get("api/post").then(({data})=>{
                    console.log(data)
                    this.posts=data.data
                }).catch(err=>{
                    Swal("Failed!!","There was something wrong.","warning")
                })
            },
            createPost(){
                    this.$Progress.start();
                      //  alert('hello');
                    this.form.post('api/post').then(res=>{
                    
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Post created successfully'
                    })
                    this.$Progress.finish();
                }).catch(err=>{
                    this.$Progress.fail()
                }); 
            }
        },
        created() {
            this.loadPosts();
         
            Fire.$on('AfterCreate',()=>{
                this.loadPosts();
            })
        }
    }
</script>
