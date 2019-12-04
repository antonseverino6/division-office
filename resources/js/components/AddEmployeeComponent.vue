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

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Official Details</h4>
                                <hr class="mt-0">
                                <div class="col-md-4">
                                    <div class="form-group-sm mb-3">
                                        <label for="birth_date">Birth Date</label>
                                        <input type="text" id="datepicker" name="birth_date" class="form-control form-control-sm">
                                    </div>  
                                    <div class="form-group-sm">
                                        <label for="gender" class="mr-2">Gender</label>
                                        <div class="form-check-inline">
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
            }
        },
        methods: {
            pickFile() {
                this.$refs.file.click()
                // document.getElementById('file').click();
            }
        },
        mounted() {
            console.log('Component mounted.')
            flatpickr('#datepicker')
        }
    }
</script>
