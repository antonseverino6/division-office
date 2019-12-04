<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Represent</div>

                    <div class="card-body">
                        <form @submit.prevent="addRepresent()" action="" method="post">
                            <div class="form-group">
                                <label for="name">Representing Name</label>
                                <input v-model="form.name" type="text" class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <button class="btn btn-success float-right" type="submit">Add</button>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Representing Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="represent in represents" :key="represent.id">
                                    <td>{{ represent.name }}</td>
                                    <td>
                                        <a href="#" @click="editRepresent(represent)">
                                            <i class="far fa-edit" style="color: green"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteRepresent(represent.id)">
                                            <i class="far fa-trash-alt" style="color: red"></i>
                                        </a>         
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="editRepresentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Represent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateRepresent()" action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="editForm.name" class="form-control" name="name" 
                            :class="{ 'is-invalid': editForm.errors.has('name') }" placeholder="Name">
                            <has-error :form="editForm" field="name"></has-error>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Represent</button>
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
                represents : {},
                form: new Form({
                    name: '',
                }),
                editForm: new Form({
                    id: '',
                    name: '',
                }),
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            loadRepresent() {
                axios.get('api/representatives')
                    .then(({data}) => {
                        (this.represents = data)
                    })
            },
            addRepresent() {
                this.form.post('api/representatives')
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Represent added successfully'
                        })

                        Fire.$emit('reloadRepresent');

                        this.form.reset();
                        this.form.clear();
                    })
            },
            editRepresent(represent) {
                this.editForm.clear();
                this.editForm.reset();
                $('#editRepresentModal').modal('show');
                this.editForm.fill(represent);
            },
            updateRepresent() {
                this.$Progress.start();
                this.editForm.patch('api/representatives/' + this.editForm.id)
                    .then(() => {
                        $('#editRepresentModal').modal('hide');

                        Toast.fire({
                        icon: 'success',
                        title: 'Represent updated successfully'
                        });

                        this.$Progress.finish();
                        Fire.$emit('reloadRepresent');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteRepresent(id) {
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
                        this.form.delete('api/representatives/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain school has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadRepresent');
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
            this.loadRepresent();
            Fire.$on('reloadRepresent', () => {
                this.loadRepresent();
            })
        }
    }
</script>
