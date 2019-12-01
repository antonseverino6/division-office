<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card mt-2">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="employee-type-tab" data-toggle="tab" href="#employee-type" role="tab" aria-controls="employee-type" aria-selected="true">Employee Type</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="employee-base-tab" data-toggle="tab" href="#employee-base" role="tab" aria-controls="employee-base" aria-selected="true">Employee Base</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="position-tab" data-toggle="tab" href="#position" role="tab" aria-controls="position" aria-selected="true">Position</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="levelsOfCivil-tab" data-toggle="tab" href="#levelsOfCivil" role="tab" aria-controls="levelsOfCivil" aria-selected="true">Levels of Civil</a>
                            </li>                            
                        </ul> 
                    </div>
                    <div class="tab-content"> 
                        <!------------------------------------- EMPLOYEE TYPE --------------------------------------------------->
                        <div class="card-body tab-pane active" id="employee-type" aria-labelledby="employee-type-tab">
                            <form @submit.prevent="AddEmployeeType()" action="" method="post">
                                <div class="form-group">
                                    <label for="name">Employee Type</label>
                                    <input type="text" v-model="addEmpTypeForm.name" name="name" id="name" 
                                    :class="{ 'is-invalid': addEmpTypeForm.errors.has('name') }" class="form-control">
                                    <has-error :form="addEmpTypeForm" field="name"></has-error>
                                </div>
                                <button class="btn btn-success float-right" type="submit">Add Employee Type</button>
                            </form>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Employee Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="employeeType in employeeTypes" :key="employeeType.id">
                                        <td>{{employeeType.name}}</td>
                                        <td>
                                            <a href="#" @click="editEmployeeType(employeeType)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteEmployeeType(employeeType.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>  
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        <!-- Employee Type Modal -->
                        <div class="modal fade" id="editEmpTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Employee Type</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateEmployeeType()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Employee Type</label>
                                        <input type="text" v-model="editEmpTypeForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editEmpTypeForm.errors.has('name') }">
                                            <has-error :form="editEmpTypeForm" field="name"></has-error>
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

                        </div>
                        <!------------------------------------- EMPLOYEE BASE --------------------------------------------------->
                        <div class="card-body tab-pane" id="employee-base" aria-labelledby="employee-base-tab">
                            <employee-base v-bind:EmployeeTypeObject="employeeTypes"></employee-base>
                        </div>
                        <!------------------------------------- POSITION --------------------------------------------------->
                        <div class="card-body tab-pane" id="position" aria-labelledby="position-tab">
                            <form @submit.prevent="addPosition()" action="" method="post">
                                <div class="form-group">
                                    <label for="name">Position</label>
                                    <input type="text" v-model="addPositionForm.name" name="name" id="name" 
                                    :class="{ 'is-invalid': addPositionForm.errors.has('name') }" class="form-control">
                                    <has-error :form="addPositionForm" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="emptype">Employee Type</label>
                                    <select id="emptype" v-model="addPositionForm.employeeType" class="form-control" :class="{ 'is-invalid': addPositionForm.errors.has('employeeType') }">
                                        <option v-for="employeeType in employeeTypes" :key="employeeType.id" :value="employeeType.id">
                                            {{employeeType.name}}
                                        </option>
                                    </select>
                                    <has-error :form="addPositionForm" field="employeeType"></has-error>
                                </div>
                                <button class="btn btn-success float-right" type="submit">Add Position</button>
                            </form>


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Assigned To</th>
                                        <th>Link Subject</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="position in positions" :key="position.id">
                                        <td>{{position.name}}</td>
                                        <td>{{position.type_of_employee.name}}</td>
                                        <td><toggle-button :value="(! position.subject) ? false : true" @change="linkSubject(position.id)" :font-size="15" :height="30" :width="100" color="#75C791" :labels="{checked: 'Linked ', unchecked: 'Unlinked '}"/></td>
                                        <td>
                                            <a href="#" @click="editPosition(position)">
                                                <i class="far fa-edit" style="color: green"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deletePosition(position.id)">
                                                <i class="far fa-trash-alt" style="color: red"></i>
                                            </a>  
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        <!-- Position Modal -->
                        <div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Position</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updatePosition()" action="" method="post">
                                    <div class="form-group">
                                        <label for="name">Position</label>
                                        <input type="text" v-model="editPositionForm.name" class="form-control" name="name" 
                                            :class="{ 'is-invalid': editPositionForm.errors.has('name') }">
                                            <has-error :form="editPositionForm" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="employeeType">Employee Type</label>
                                        <select name="type_of_employee_id" v-model="editPositionForm.type_of_employee_id" id="employeeType" class="form-control" 
                                        :class="{ 'is-invalid': editPositionForm.errors.has('type_of_employee_id') }">
                                            <option v-for="employeeType in employeeTypes" :key="employeeType.id" :value="employeeType.id">
                                                {{ employeeType.name }}
                                            </option>
                                        </select>
                                        <has-error :form="editPositionForm" field="type_of_employee_id"></has-error>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Update Position</button>
                                    </div>

                                </form>
                            </div>

                            </div>
                        </div>
                        </div>

                        </div>

                        <div class="card-body tab-pane" id="levelsOfCivil" aria-labelledby="levelsOfCivil-tab">
                            <levels-of-civil></levels-of-civil>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LevelsOfCivil from './LevelsOfCivilComponent.vue'
    import EmployeeBase from './EmployeeBaseComponent.vue'
    export default {
        components: {
            LevelsOfCivil,
            EmployeeBase
        },
        data() {
            return {
                employeeTypes: {},
                addEmpTypeForm: new Form({
                    name: '',
                }),
                editEmpTypeForm: new Form({
                    id: '',
                    name: '',
                }),
                employeeBases: {},
                addEmpBaseForm: new Form({
                    name: '',
                    employeeType: '',
                }),
                editEmpBaseForm: new Form({
                    id: '',
                    name: '',
                    type_of_employee_id: '',
                }),
                positions: {},
                addPositionForm: new Form({
                    name: '',
                    employeeType: '',
                }),
                editPositionForm: new Form({
                    id: '',
                    name: '',
                    type_of_employee_id: '',
                    subject: '',
                }),
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            loadEmployeeType() {
                axios.get('api/typeOfEmployees')
                     .then(({data}) => (this.employeeTypes = data))
            },
            AddEmployeeType() {
                this.$Progress.start();
                this.addEmpTypeForm.post('api/typeOfEmployees')
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Employee Type added successfully'
                        }) 

                        this.addEmpTypeForm.reset();
                        this.addEmpTypeForm.clear();

                        Fire.$emit('reloadEmployeeType');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editEmployeeType(employeeType) {
                this.editEmpTypeForm.reset();
                this.editEmpTypeForm.clear();
                $('#editEmpTypeModal').modal('show');
                this.editEmpTypeForm.fill(employeeType);
            },
            updateEmployeeType() {
                this.$Progress.start();
                this.editEmpTypeForm.patch('api/typeOfEmployees/' + this.editEmpTypeForm.id)
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Employee Type updated successfully'
                        }) 

                        this.addEmpTypeForm.reset();
                        this.addEmpTypeForm.clear();

                        Fire.$emit('reloadEmployeeType');
                        $('#editEmpTypeModal').modal('hide');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteEmployeeType(id) {
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
                        this.editEmpTypeForm.delete('api/typeOfEmployees/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain employee type has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadEmployeeType');
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
            },
            loadEmployeeBase() {
                axios.get('api/employeeBase')
                     .then(({data}) => (this.employeeBases = data))
            },
            AddEmployeeBase() {
                this.$Progress.start();
                this.addEmpBaseForm.post('api/employeeBase')
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Employee Type added successfully'
                        }) 

                        this.addEmpBaseForm.reset();
                        this.addEmpBaseForm.clear();

                        Fire.$emit('reloadEmployeeBase');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editEmployeeBase(employeeBase) {
                this.editEmpBaseForm.reset();
                this.editEmpBaseForm.clear();
                $('#editEmpBaseModal').modal('show');
                this.editEmpBaseForm.fill(employeeBase);
            },
            updateEmployeeBase() {
                this.$Progress.start();
                this.editEmpBaseForm.patch('api/employeeBase/' + this.editEmpBaseForm.id)
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Employee Base updated successfully'
                        })  
                        $('#editEmpBaseModal').modal('hide');
                        this.$Progress.finish();
                        Fire.$emit('reloadEmployeeBase');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteEmployeeBase(id) {
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
                        this.editEmpBaseForm.delete('api/employeeBase/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain employee base has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadEmployeeBase');
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
            },
            loadPositions() {
                axios.get('api/positions')
                     .then(({data}) => (this.positions = data))
            },
            addPosition() {
                this.$Progress.start();
                this.addPositionForm.post('api/positions')
                    .then(() => {
                        
                        Toast.fire({
                        icon: 'success',
                        title: 'Position added successfully'
                        })  
                        
                        this.addPositionForm.clear();
                        this.addPositionForm.reset();

                        this.$Progress.finish();
                        Fire.$emit('reloadPositions');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            editPosition(position) {
                this.editPositionForm.clear();
                this.editPositionForm.reset();
                $('#editPositionModal').modal('show');
                this.editPositionForm.fill(position);
            },
            updatePosition() {
                this.$Progress.start();
                this.editPositionForm.patch('api/positions/' + this.editPositionForm.id)
                    .then(() => {
                        Toast.fire({
                        icon: 'success',
                        title: 'Position updated successfully'
                        })  
                        $('#editPositionModal').modal('hide');
                        this.$Progress.finish();
                        Fire.$emit('reloadPositions');                    
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deletePosition(id) {
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
                        this.editPositionForm.delete('api/positions/' + id)
                            .then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Certain position has been deleted.',
                                'success'
                                );

                                Fire.$emit('reloadPositions');
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
            },
            linkSubject(id) {
                axios.patch('api/linkSubject/'  + id)
                     .catch(() => {
                         alert('something went wrong')
                     });

            },
         },
        created() {
            this.loadEmployeeType();
            this.loadEmployeeBase();
            this.loadPositions();
            Fire.$on('reloadEmployeeType', () => {
                this.loadEmployeeType();
            });
            Fire.$on('reloadEmployeeBase', () => {
                this.loadEmployeeBase();
            });
            Fire.$on('reloadPositions', () => {
                this.loadPositions();
            });
        }
    }
</script>
