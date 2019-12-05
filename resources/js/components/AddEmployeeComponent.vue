<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">Add Employee</div>

                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-4 text-right">
                                <input type="file" ref="file" accept="image/jpeg,image/jpg,image/png" id="file" style="display: none;">
                                <img :src="default_img" @click="pickFile" class="mr-5" style="border: 1px solid #000; cursor: pointer" width="200" height="200" alt="">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    <label for="fname">First Name</label>
                                    <input type="text" id="fname" name="first_name" class="form-control form-control-sm">
                                </div>
                                <div class="form-group-sm">
                                    <label for="mname">Middle Name</label>
                                    <input type="text" id="mname" name="middle_name" class="form-control form-control-sm">
                                </div> 
                                <div class="form-group-sm">
                                    <label for="lname">Last Name</label>
                                    <input type="text" id="lname" name="last_name" class="form-control form-control-sm">
                                </div>                                                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    <label for="emp_id">Employee ID</label>
                                    <input type="text" id="emp_id" name="emp_id" class="form-control form-control-sm">
                                </div>
                                <div class="form-group-sm">
                                    <label for="tin_no">Tin No.</label>
                                    <input type="text" id="tin_no" name="tin_no" class="form-control form-control-sm">
                                </div> 
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h4>Official Details</h4>
                                <hr class="mt-0">
                            </div>    
                                
                                <div class="col-md-3 border-right">
                                    <div class="form-group-sm mb-3">
                                        <label for="birth_date">Birth Date</label>
                                        <input type="text" id="datepicker" name="birth_date" class="form-control form-control-sm">
                                    </div>  
                                    <div class="form-group-sm mb-3">
                                        <label for="birth_place">Birth Place</label>
                                        <input type="text" id="birth_place" name="birth_place" class="form-control form-control-sm">
                                    </div> 
                                    <div class="form-group-sm">
                                        <label for="gender" class="mr-2" style="display:block">Gender</label>
                                        <div class="form-check-inline ml-3">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" :value="male">
                                            <i class="fas fa-male"></i> Male
                                        </label>
                                        </div>
                                        <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" :value="female">
                                            <i class="fas fa-female"></i> Female
                                        </label>
                                        </div> 
                                    </div>    
                                </div>
                                <div class="col-md-5 border-right">
                                    <div class="form-group">
                                        <label for="civil_status">Civil Status</label>
                                        <input type="text" class="form-control form-control-sm" name="civil_status" id="civil_status">
                                    </div>
                                    <div class="form-group">
                                        <label for="per_address">Permanent Address</label>
                                        <input type="text" class="form-control form-control-sm" name="per_address" id="per_address">
                                    </div>                                    
                                </div>
                                <div class="col-md-4 border-right">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        <input type="text" class="form-control form-control-sm" name="contact_no" id="contact_no">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control form-control-sm" name="email" id="email">
                                    </div>                                    
                                </div>     
                        </div> <!-- END OF ROW 2 -->

                        <div class="row mt-3">
                            <div class="col-md-4 border-right">
                                <div class="form-group">
                                    <label for="role_type">Role Type</label>
                                    <input type="text" class="form-control form-control-sm" name="role_type" id="role_type">
                                </div>
                                <div class="form-group">
                                    <label for="emp_status">Employment Status</label>
                                    <select class="form-control form-control-sm" name="emp_status" id="emp_status">
                                        <option value="">-- Select --</option>
                                        <option v-for="empStatus in empStatuses" :key="empStatus.id" :value="empStatus.id">{{empStatus.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="job_code">Job Title Code</label>
                                    <input type="text" class="form-control form-control-sm" name="job_code" id="job_code">
                                </div>
                            </div>
                            <div class="col-md-4 border-right">
                                <div class="form-group">
                                    <label for="date_join">Date of Joining</label>
                                    <input type="text" id="datepicker" name="date_join" class="form-control form-control-sm">
                                </div> 
                                <div class="form-group">
                                    <label for="date_appoint">Date of Original Appointment</label>
                                    <input type="text" id="datepicker" name="date_appoint" class="form-control form-control-sm">
                                </div> 
                                <div class="form-group">
                                    <label for="work_shift">Work Shift</label>
                                    <input type="text" class="form-control form-control-sm" name="work_shift" id="work_shift">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="biometric">Biometric ID/RFID</label>
                                    <input type="text" class="form-control form-control-sm" name="biometric" id="biometric">
                                </div>
                                <div class="form-group">
                                    <label for="item_num">Complete Item No.</label>
                                    <input type="text" class="form-control form-control-sm" name="item_num" id="item_num">
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
                default_img: '/img/default_userprofile.png',
                empStatuses: {},
            }
        },
        methods: {
            pickFile() {
                this.$refs.file.click()
                // document.getElementById('file').click();
            },
            loadEmpStatus() {
                axios.get('api/employment-status')
                     .then(({data}) => {
                         (this.empStatuses = data)
                     })
            }
        },
        mounted() {
            console.log('Component mounted.')
            flatpickr('#datepicker')
        },
        created() {
            this.loadEmpStatus();
        }

    }
</script>
