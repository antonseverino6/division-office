<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Schools</div>

                    <div class="card-body">
                        <form @submit.prevent="addSchool()" action="" method="post">
                            <div class="form-group">
                                <label for="name">Add a School</label>
                                <input v-model="form.name" type="text" class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('name') }" placeholder="School name">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <button class="btn btn-success float-right" type="submit">Add School</button>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>School Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="schools.length < 1">
                                <h3 class="text-center">No Schools Yet</h3> 

                            </tbody>
                            <tbody v-else>
                                <tr v-for="school in schools" :key="school.id">
                                    <td>{{ school.name }}</td>
                                    <td>
                                        <a href="#" @click="editSchool(school)">
                                            <i class="far fa-edit" style="color: green"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteSchool(school.id)">
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
        <div class="modal fade" id="editSchoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateSchool()" action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="editForm.name" class="form-control" name="name" 
                            :class="{ 'is-invalid': editForm.errors.has('name') }" placeholder="Name">
                            <has-error :form="editForm" field="name"></has-error>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update School</button>
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
                schools : {},
                form: new Form({
                    id: '',
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
            loadSchools() {
                axios.get('api/schools')
                    .then(({data}) => {
                        (this.schools = data)
                    })
            },
            addSchool() {
                this.form.post('api/schools')
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'School added successfully'
                        })

                        Fire.$emit('reloadSchools');

                        this.form.reset();
                        this.form.clear();
                    })
            },
            editSchool(school) {
                this.editForm.clear();
                this.editForm.reset();
                $('#editSchoolModal').modal('show');
                this.editForm.fill(school);
            },
            updateSchool() {
                this.$Progress.start();
                this.editForm.patch('api/schools/' + this.editForm.id)
                    .then(() => {
                        $('#editSchoolModal').modal('hide');

                        Toast.fire({
                        icon: 'success',
                        title: 'School updated successfully'
                        });

                        this.$Progress.finish();
                        Fire.$emit('reloadSchools');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteSchool(id) {
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
                        this.form.delete('api/schools/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain school has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadSchools');
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
            this.loadSchools();
            Fire.$on('reloadSchools', () => {
                this.loadSchools();
            })
        }
    }
</script>
