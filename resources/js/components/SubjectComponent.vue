<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card mt-2">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="subjects-tab" data-toggle="tab" href="#subjects" role="tab" aria-controls="subjects" aria-selected="true">Subjects</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="area-tab" data-toggle="tab" href="#area" role="tab" aria-controls="area" aria-selected="true">Areas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="component-tab" data-toggle="tab" href="#component" role="tab" aria-controls="component" aria-selected="true">Components</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="gradeLevel-tab" data-toggle="tab" href="#gradeLevel" role="tab" aria-controls="gradeLevel" aria-selected="true">Grade Level</a>
                            </li>                            
                        </ul> 
                    </div>
                    <div class="tab-content">
                        <!---------------------------------- Subjects -------------------------------------> 
                        <div class="card-body tab-pane active" id="subjects" aria-labelledby="subjects-tab">
                            <form @submit.prevent="addSubject()" action="" method="post">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" v-model="addSubjectForm.name" class="form-control" 
                                     :class="{ 'is-invalid': addSubjectForm.errors.has('name') }" id="subject" placeholder="Subject Name">
                                    <has-error :form="addSubjectForm" field="name"></has-error>
                                </div>
                                <button type="submit" class="btn btn-success float-right">Add Subject</button>
                            </form>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Subjects</th>
                                        <th></th>
                                    </tr>
                                    
                                </thead>
                                <tbody v-if="subjects.length > 0">
                                    <tr v-for="subject in subjects" :key="subject.id">
                                        <td>{{ subject.name }}</td>
                                        <td>
                                            <a href="#" @click="editSubject(subject)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteSubject(subject.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>     
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <h3 class="text-center">No Subjects Yet</h3>
                                </tbody>
                            </table>

                        </div>

                        <!-- Subjects Modal -->
                        <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Subject</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateSubject()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Subject Name</label>
                                        <input type="text" v-model="editSubjectForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editSubjectForm.errors.has('name') }" placeholder="Name">
                                            <has-error :form="editSubjectForm" field="name"></has-error>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update Subject</button>
                                    </div>

                                </form>
                            </div>

                            </div>
                        </div>
                        </div>

                        <!---------------------------------- Area ------------------------------------->
                        <div class="card-body tab-pane" id="area" aria-labelledby="area-tab">
                            <form @submit.prevent="addArea()" action="" method="post">
                                <div class="form-group">
                                    <label for="name">Area</label>
                                    <input type="text" v-model="addAreaForm.name" class="form-control" 
                                     :class="{ 'is-invalid': addAreaForm.errors.has('name') }" id="name" placeholder="Area Name">
                                    <has-error :form="addAreaForm" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Assign to a Subject</label>
                                    <select v-model="addAreaForm.subject" id="subject"
                                    :class="{ 'is-invalid': addAreaForm.errors.has('subject') }" class="form-control">
                                        <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                            {{subject.name}}
                                        </option>
                                    </select>
                                    <has-error :form="addAreaForm" field="subject"></has-error> 
                                </div>
                                <button type="submit" class="btn btn-success float-right">Add Area</button>
                            </form>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Area</th>
                                        <th>Subject</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="area in areas" :key="area.id">
                                        <td>{{ area.name }}</td>
                                        <td>{{ area.subject.name }}</td>
                                        <td>
                                            <a href="#" @click="editArea(area)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteArea(area.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>   
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        <!-- Areas Modal -->
                        <div class="modal fade" id="editAreaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Area</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateArea()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Area Name</label>
                                        <input type="text" v-model="editAreaForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editAreaForm.errors.has('name') }" placeholder="Name">
                                            <has-error :form="editAreaForm" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <select name="subject_id" v-model="editAreaForm.subject_id" id="subject" class="form-control" 
                                        :class="{ 'is-invalid': editAreaForm.errors.has('subject_id') }">
                                            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                                {{ subject.name }}
                                            </option>
                                        </select>
                                        <has-error :form="editAreaForm" field="subject_id"></has-error>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update Area</button>
                                    </div>

                                </form>
                            </div>

                            </div>
                        </div>
                        </div>

                        </div>

                        <!---------------------------------- Components ------------------------------------->
                        <div class="card-body tab-pane" id="component" aria-labelledby="component-tab">
                            <form @submit.prevent="addComponent()" action="" method="post">
                                <div class="form-group">
                                    <label for="name">Component</label>
                                    <input type="text" v-model="addComponentForm.name" class="form-control" 
                                     :class="{ 'is-invalid': addComponentForm.errors.has('name') }" id="name" placeholder="Component Name">
                                    <has-error :form="addComponentForm" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="area">Assign to an Area</label>
                                    <select v-model="addComponentForm.area" id="area"
                                    :class="{ 'is-invalid': addComponentForm.errors.has('area') }" class="form-control">
                                        <option v-for="area in areas" :key="area.id" :value="area.id">
                                            {{area.name}}
                                        </option>
                                    </select>
                                    <has-error :form="addComponentForm" field="area"></has-error> 
                                </div>
                                <button type="submit" class="btn btn-success float-right">Add Component</button>
                            </form>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Component</th>
                                        <th>Area</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody v-if="components.length > 0">
                                    <tr v-for="component in components" :key="component.id">
                                        <td>{{ component.name }}</td>
                                        <td>{{ component.area.name }}</td>
                                        <td>
                                            <a href="#" @click="editComponent(component)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteComponent(component.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>    
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <h3 class="text-center">No Components Yet</h3>
                                </tbody>
                            </table>

                        <!-- Components Modal -->
                        <div class="modal fade" id="editComponentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Component</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateComponent()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Component Name</label>
                                        <input type="text" v-model="editComponentForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editComponentForm.errors.has('name') }" placeholder="Name">
                                            <has-error :form="editComponentForm" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="area">Area</label>
                                        <select name="area_id" v-model="editComponentForm.area_id" id="area" class="form-control" 
                                        :class="{ 'is-invalid': editComponentForm.errors.has('area_id') }">
                                            <option v-for="area in areas" :key="area.id" :value="area.id">
                                                {{ area.name }}
                                            </option>
                                        </select>
                                        <has-error :form="editComponentForm" field="area_id"></has-error>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update Component</button>
                                    </div>

                                </form>
                            </div>

                            </div>
                        </div>
                        </div>


                        </div>

                        <!---------------------------------- Grade Level ------------------------------------->
                        <div class="card-body tab-pane" id="gradeLevel" aria-labelledby="gradeLevel-tab">
                            <form @submit.prevent="addGradeLevel()" action="" method="post">
                                <div class="form-group">
                                    <label for="name">Grade Level</label>
                                    <input type="text" v-model="addGradeLevelForm.name" class="form-control" 
                                     :class="{ 'is-invalid': addGradeLevelForm.errors.has('name') }" id="name" placeholder="Grade Level Name">
                                    <has-error :form="addGradeLevelForm" field="name"></has-error>
                                </div>
                                <button type="submit" class="btn btn-success float-right">Add Grade Level</button>
                            </form>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Grade Level</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="gradeLevel in gradeLevels" :key="gradeLevel.id">
                                        <td>{{ gradeLevel.name }}</td>
                                        <td>
                                            <a href="#" @click="editGradeLevel(gradeLevel)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteGradeLevel(gradeLevel.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>   
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        <!-- Areas Modal -->
                        <div class="modal fade" id="editGradeLevelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Grade Level</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateGradeLevel()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Area Name</label>
                                        <input type="text" v-model="editGradeLevelForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editGradeLevelForm.errors.has('name') }" placeholder="Name">
                                            <has-error :form="editGradeLevelForm" field="name"></has-error>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update Grade Level</button>
                                    </div>

                                </form>
                            </div>

                            </div>
                        </div>
                        </div>

                        </div>


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
                subjects: {},
                addSubjectForm: new Form ({
                    name: '',
                }),
                editSubjectForm: new Form ({
                    id: '',
                    name: '',
                }),
                areas: {},
                addAreaForm: new Form ({
                    name: '',
                    subject: '',
                }),
                editAreaForm: new Form({
                    id: '',
                    name: '',
                    subject_id: '',
                }),
                components: {},
                addComponentForm: new Form({
                    name: '',
                    area: '',
                }),
                editComponentForm: new Form({
                    id: '',
                    name: '',
                    area_id: '',
                }),
                gradeLevels: {},
                addGradeLevelForm: new Form({
                    name: '',
                }),
                editGradeLevelForm: new Form({
                    id: '',
                    name: '',
                }),                
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            loadSubjects() {
                axios.get('api/subjects')
                    .then(({data}) => (this.subjects = data));
            },
            addSubject() {
                this.$Progress.start();
                this.addSubjectForm.post('api/subjects')
                    .then(() => {

                        Toast.fire({
                        icon: 'success',
                        title: 'Subject added successfully'
                        })

                        this.$Progress.finish();
                        Fire.$emit('reloadSubjects');
                        this.addSubjectForm.clear();
                        this.addSubjectForm.reset();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editSubject(subject) {
                $('#editSubjectModal').modal('show');
                this.editSubjectForm.clear();
                this.editSubjectForm.reset();
                this.editSubjectForm.fill(subject);
            },
            updateSubject() {
                this.$Progress.start();
                this.editSubjectForm.patch('api/subjects/' + this.editSubjectForm.id)
                    .then(() => {
                        $('#editSubjectModal').modal('hide');
                        Toast.fire({
                        icon: 'success',
                        title: 'Subject updated successfully'
                        })

                        this.$Progress.finish();
                        Fire.$emit('reloadSubjects');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteSubject(id) {
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
                        this.editSubjectForm.delete('api/subjects/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain subject has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadSubjects');
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
            }, // END OF SUBJECTS
            loadAreas() { // START OF AREA
                axios.get('api/areas')
                    .then(({data}) => (this.areas = data))
            },
            addArea() {
                this.$Progress.start();
                this.addAreaForm.post('api/areas')
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Area added successfully'
                        }) 
                        this.addAreaForm.clear();
                        this.addAreaForm.reset();
                        this.$Progress.finish();
                        Fire.$emit('reloadAreas');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editArea(area) {
                this.editAreaForm.clear();
                this.editAreaForm.reset();
                $('#editAreaModal').modal('show');
                this.editAreaForm.fill(area);
            },
            updateArea() {
                this.$Progress.start();
                this.editAreaForm.patch('api/areas/' + this.editAreaForm.id)
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Area updated successfully'
                        })  
                        $('#editAreaModal').modal('hide');
                        this.$Progress.finish();
                        Fire.$emit('reloadAreas');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteArea(id) {
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
                        this.editAreaForm.delete('api/areas/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain area has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadAreas');
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
            }, // END OF AREA
            loadComponents() { // START OF COMPONENTS
                axios.get('api/components') 
                    .then(({data}) => (this.components = data))
            },
            addComponent() {
                this.$Progress.start();
                this.addComponentForm.post('api/components')
                    .then(() => {

                        Toast.fire({
                        icon: 'success',
                        title: 'Component updated successfully'
                        })  

                        $('#editComponentModal').modal('hide');

                        this.$Progress.finish();
                        Fire.$emit('reloadComponents');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editComponent(component) {
                $('#editComponentModal').modal('show');
                this.editComponentForm.reset();
                this.editComponentForm.clear();
                this.editComponentForm.fill(component);
            },
            updateComponent() {
                this.$Progress.start();
                this.editComponentForm.patch('api/components/' + this.editComponentForm.id)
                    .then(() => {

                        Toast.fire({
                        icon: 'success',
                        title: 'Component updated successfully'
                        });  

                        $('#editComponentModal').modal('hide');

                        this.$Progress.finish();
                        Fire.$emit('reloadComponents');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteComponent(id) {
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
                        this.editComponentForm.delete('api/components/' + id)
                        .then(() => {
                            Swal.fire(
                            'Deleted!',
                            'Certain component has been deleted.',
                            'success'
                            );

                            Fire.$emit('reloadComponents');
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
            }, //END COMPONENT
            loadGradeLevels() { //START GRADE LEVEL
                axios.get('api/grade-levels')
                     .then(({data}) => (this.gradeLevels = data))
            },
            addGradeLevel() {
                this.$Progress.start();
                this.addGradeLevelForm.post('api/grade-levels')
                    .then(() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Grade Level added successfully'
                        })

                        this.$Progress.finish();
                        Fire.$emit('reloadGradeLevels');
                        this.addGradeLevelForm.clear();
                        this.addGradeLevelForm.reset();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editGradeLevel(gradeLevel) {
                this.editGradeLevelForm.clear();
                this.editGradeLevelForm.reset();
                $('#editGradeLevelModal').modal('show');
                this.editGradeLevelForm.fill(gradeLevel);
            },
            updateGradeLevel() {
                this.editGradeLevelForm.patch('api/grade-levels/' + this.editGradeLevelForm.id)
                    .then(() => {

                        Toast.fire({
                        icon: 'success',
                        title: 'Grade Level updated successfully'
                        });  

                        $('#editGradeLevelModal').modal('hide');

                        this.$Progress.finish();
                        Fire.$emit('reloadGradeLevels');
                    })
            },
            deleteGradeLevel(id) {
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
                        this.editGradeLevelForm.delete('api/grade-levels/' + id)
                        .then(() => {
                            Swal.fire(
                            'Deleted!',
                            'Certain grade level has been deleted.',
                            'success'
                            );

                            Fire.$emit('reloadGradeLevels');
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
            this.loadSubjects();
            this.loadAreas();
            this.loadComponents();
            this.loadGradeLevels();
            Fire.$on('reloadSubjects', () => {
                this.loadSubjects();
            });
            Fire.$on('reloadAreas', () => {
                this.loadAreas();
            });
            Fire.$on('reloadComponents', () => {
                this.loadComponents();
            })
            Fire.$on('reloadGradeLevels', () => {
                this.loadGradeLevels();
            })
        }
    }
</script>
