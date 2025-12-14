<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Create Employee</a>
                <a type="button" class="btn btn-dark">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </a>
            </div>
        </nav>
        <main class="container-fluid">
            <div class="container relative">
                <div class="row">


                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="">Employee ID</label>
                                    <div class="employee-info">{{ employee.employee_id }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="">Name</label>
                                    <div class="employee-info">{{ employee.employee_name }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="">Designation</label>
                                    <div class="employee-info">{{ employee.designation }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 d-flex align-items-center justify-content-center dark-bg">
                            <div class="card" style="width: 18rem;">
                                <img :src="img" class="card-img-top" alt="">
                                    <div class="card-body text-center">

                                    </div>
                            </div>
                            <!-- <div class="payroll-image-add-box">
                                <div class="inner" :class="{ has: !!img }">
                                    <img v-if="img" :src="img" alt="">
                                        <div class="button-box">
                                            <button @click="addImage">Add Image</button>
                                        </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="">Department</label>
                        <div class="employee-info">{{ employee.department.name}}</div>
                       

                    </div>

                    <div class="col-6">
                        <label class="form-label" for="">Joining Date</label>

                        <div class="employee-info">{{ employee.joining_date }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Contact No</label>

                        <div class="employee-info">{{ employee.contact_no }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">NID No.</label>

                        <div class="employee-info">{{ employee.nid }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">Email</label>

                        <div class="employee-info">{{ employee.email }}</div>
                    </div>





                    <div class="col-12">
                        <label class="form-label" for="">Current Address</label>

                        <div class="employee-info">{{ employee.current_address }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="">Permanent Address</label>

                        <div class="employee-info">{{ employee.permanent_address }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="">linkedin</label>

                        <div class="employee-info">{{ employee.linkedin }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">District</label>

                        <div class="employee-info">{{ employee.district }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Police Station</label>

                        <div class="employee-info">{{ employee.police_station }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Post Office</label>

                        <div class="employee-info">{{ employee.post_office }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="">Village/Road</label>

                        <div class="employee-info">{{ employee.village }}</div>
                    </div>

                    <div class=" col-md-6">
                        <label class="form-label" for="">Father</label>

                        <div class="employee-info">{{ employee.father }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Mother</label>

                        <div class="employee-info">{{ employee.mother }}</div>
                    </div>





                </div>
                <LoaderBox v-if="busy"></LoaderBox>
            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">



import { VueDatePicker } from "@vuepic/vue-datepicker"
import VueMultiselect from 'vue-multiselect'
import { useForm } from '@inertiajs/vue3';
import moment from 'moment'
import Layout from '../../../components/Layout.vue';
import Swal from 'sweetalert2'
import { ref } from "vue";
import LoaderBox from "../../../components/LoaderBox.vue";
import { values } from "lodash";
import { head } from "lodash";
const { auth } = defineProps<{
    auth: Auth,
    employee: Employee


}>();
const img = ref();
const busy = ref(false)








</script>



<style lang="scss" scoped>
@import 'sweetalert2/src/sweetalert2.scss';
.employee-info{
    text-transform: capitalize;
    padding-left: 20px;
}
</style>