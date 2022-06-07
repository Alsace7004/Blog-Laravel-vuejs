<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <!--<div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">Add</button>
                        </div>-->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered At</th>
                                <!--<th>Actions</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name|upText}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.created_at}}</td>
                                    <!--<td>
                                        <a href="" @click.prevent="editModal(categorie)"><i class="fa fa-edit"></i></a>-->
                                        <!--<button type="submit" @click="deleteCategory(categorie.id)"><i class="fa fa-trash"></i></button>-->
                                        <!--<a href="" @click.prevent="deleteCategory(categorie.id)"><i class="fa fa-trash"></i></a>
                                    </td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
          </div>
        </div> <!-- /.end row -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users:[],
            }
        },
        methods:{
            loadUsers(){
                axios.get('api/user').then((users)=>{
                    this.users = users.data;
                })
            },
        },
        created(){
            this.loadUsers();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
