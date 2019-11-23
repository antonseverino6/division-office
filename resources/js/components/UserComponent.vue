<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">
                        Users

                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" @click="addNewUserModal"> 
                            Add New <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td> 
                                        <a href="#" @click="deleteUser(user.id)">
                                            <i class="far fa-trash-alt" style="color: red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        This is a footer
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="editMode ? updateUser() : createUser()" action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="form.name" class="form-control" name="name" 
                            :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name">
                            <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" v-model="form.email" class="form-control" name="email" id="email"
                              :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="">Role</label>
                        </div>
                         &nbsp;
                        <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" v-model="form.admin" class="form-check-input" name="admin" value="1">Admin
                        </label>
                        </div>
                        <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" v-model="form.admin" class="form-check-input" name="admin" value="0" checked>User
                        </label>
                        <has-error :form="form" field="admin"></has-error>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" v-model="form.password" class="form-control" name="password" id="password"
                            :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" v-model="form.password_confirmation" class="form-control" name="password_confirmation" 
                            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"    placeholder="Confirm Password">
                        <has-error :form="form" field="password_confirmation"></has-error>        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create User</button>
                    </div>

                </form>
            </div>

            </div>
        </div>
        </div>



    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                users : {},
                form: new Form({
                    name: '',
                    email: '',
                    admin: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },
        mounted() {
            console.log('mounted successfully')
        },
        methods: {
            loadUsers() {
                axios.get('api/users')
                    .then(({data}) => (this.users = data));
            },
            addNewUserModal() {
                this.editMode = false;
                this.form.clear();
                this.form.reset();
                $('#addNewUserModal').modal('show');
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/users')
                    .then(() => {
                        Fire.$emit('reloadUsers');
                        $('#addNewUserModal').modal('hide');

                        Toast.fire({
                        icon: 'success',
                        title: 'User created successfully'
                        })

                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteUser(id) {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('api/users/'+ id)
                            .then(() => {
                                
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                );
                                Fire.$emit('reloadUsers');
                            })
                            .catch(() => {
                                Swal.fire(
                                'Something Went Wrong',
                                '',
                                'warning'
                                )    
                            })

                    }
                })
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('reloadUsers', () => {
                this.loadUsers();
            });
        }
    }
</script>
