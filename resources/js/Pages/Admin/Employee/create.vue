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
                                    <input class="form-control" placeholder="Employee ID" v-model="form.employee_id"
                                        :class="{ 'is-invalid': !!form.errors.employee_id }" />
                                    <div class="invalid-feedback">{{ form.errors.employee_id }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="">Name</label>
                                    <input class="form-control" placeholder="Name" v-model="form.employee_name"
                                        :class="{ 'is-invalid': !!form.errors.employee_name }" />
                                    <div class="invalid-feedback">{{ form.errors.employee_name }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="">Designation</label>
                                    <input class="form-control" placeholder="Designation" v-model="form.designation"
                                        :class="{ 'is-invalid': !!form.errors.designation }" />
                                    <div class="invalid-feedback">{{ form.errors.designation }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 d-flex align-items-center justify-content-center dark-bg">
                            <div class="card" style="width: 18rem;">
                                <img :src="img" class="card-img-top" alt="">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-dark" @click="addImage">
                                            {{ img ? 'Replace Image' : 'Insert Image' }}</button>
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

                    <div class="col-6" :class="{ 'invalid': !!form.errors.department }">
                        <label class="form-label" for="">Department</label>
                        <VueMultiselect :model-value="form.department" :options="departments" :searchable="false"
                            :close-on-select="false" :allow-empty="false" @update:model-value="updateSelected"
                            label="name" placeholder="Select one" track-by="name"></VueMultiselect>

                        <div class="invalid-meessage">{{ form.errors.department }}</div>

                    </div>

                    <div class="col-6">
                        <label class="form-label" for="">Joining Date</label>
                        <input class="form-control" placeholder="Joining Date" v-model="form.joining_date"
                            :class="{ 'is-invalid': !!form.errors.joining_date }" type="date" />
                        <div class="invalid-feedback">{{ form.errors.joining_date }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Contact No</label>
                        <input class="form-control" placeholder="Contact no" v-model="form.contact_no"
                            :class="{ 'is-invalid': !!form.errors.contact_no }" />
                        <div class="invalid-feedback">{{ form.errors.contact_no }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">NID No.</label>
                        <input class="form-control" placeholder="NID" v-model="form.nid"
                            :class="{ 'is-invalid': !!form.errors.nid }" />
                        <div class="invalid-feedback">{{ form.errors.nid }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">Email</label>
                        <input class="form-control" placeholder="Email" v-model="form.email"
                            :class="{ 'is-invalid': !!form.errors.email }" />
                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="">Login Password</label>
                        <input class="form-control" placeholder="Login Password" v-model="form.password"
                            :class="{ 'is-invalid': !!form.errors.password }" />
                        <div class="invalid-feedback">{{ form.errors.password }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="">Current Address</label>
                        <input class="form-control" placeholder="Current Address" v-model="form.current_address"
                            :class="{ 'is-invalid': !!form.errors.current_address }" />
                        <div class="invalid-feedback">{{ form.errors.current_address }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="">Permanent Address</label>
                        <input class="form-control" placeholder="Permanent Address" v-model="form.permanent_address"
                            :class="{ 'is-invalid': !!form.errors.permanent_address }" />
                        <div class="invalid-feedback">{{ form.errors.permanent_address }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="">linkedin</label>
                        <input class="form-control" placeholder="linkedin" v-model="form.linkedin"
                            :class="{ 'is-invalid': !!form.errors.linkedin }" />
                        <div class="invalid-feedback">{{ form.errors.linkedin }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">District</label>
                        <input class="form-control" placeholder="District" v-model="form.district"
                            :class="{ 'is-invalid': !!form.errors.district }" />
                        <div class="invalid-feedback">{{ form.errors.district }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Police Station</label>
                        <input class="form-control" placeholder="Police Station" v-model="form.police_station"
                            :class="{ 'is-invalid': !!form.errors.police_station }" />
                        <div class="invalid-feedback">{{ form.errors.police_station }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Post Office</label>
                        <input class="form-control" placeholder="Police Station" v-model="form.post_office"
                            :class="{ 'is-invalid': !!form.errors.post_office }" />
                        <div class="invalid-feedback">{{ form.errors.post_office }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="">Village/Road</label>
                        <input class="form-control" placeholder="Village/Road" v-model="form.village"
                            :class="{ 'is-invalid': !!form.errors.village }" />
                        <div class="invalid-feedback">{{ form.errors.village }}</div>
                    </div>

                    <div class=" col-md-6">
                        <label class="form-label" for="">Father</label>
                        <input class="form-control" placeholder="father" v-model="form.father"
                            :class="{ 'is-invalid': !!form.errors.father }" />
                        <div class="invalid-feedback">{{ form.errors.father }}</div>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="">Mother</label>
                        <input class="form-control" placeholder="mother" v-model="form.mother"
                            :class="{ 'is-invalid': !!form.errors.mother }" />
                        <div class="invalid-feedback">{{ form.errors.mother }}</div>
                    </div>


                    <div class="col-12 text-center my-4">
                        <button class="btn btn-primary btn-lg" @click="save">Save</button>
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
const { auth,employee } = defineProps<{
    auth: Auth
    departments: any,
    employee?:Employee

}>();
const img = ref();
const busy = ref(false)

const form = useForm<any>({

    employee_id: null,
    employee_name: null,
    designation: null,
    department: null,
    joining_date: null,
    contact_no: null,
    email: null,
    linkedin: null,
    nid: null,
    current_address: null,
    permanent_address: null,
    district: null,
    police_station: null,
    post_office: null,
    village: null,
    father: null,
    mother: null,
    password: null,
    avatar: null
})



if(employee){
    form.employee_id  = employee.employee_id;
    form.employee_name = employee.employee_name;
    form.designation = employee.designation;
    form.department = employee.department;
    form.email = employee.email;
    form.contact_no =employee.contact_no;
    form.linkedin = employee.linkedin;
    form.nid = employee.nid;
    form.joining_date = employee.joining_date;
    form.current_address = employee.current_address;
    form.permanent_address = employee.permanent_address;
    form.district = employee.district;
    form.police_station = employee.police_station;
    form.village = employee.village;
    form.father = employee.father;
    form.mother = employee.mother;
    img.value = employee.avatarUrl
    
}
const updateSelected = (val: any) => {
    form.department = val;
}

const save = async () => {



    //   busy.value = true;
    try {
        const formData = new FormData;
        formData.append("employee_id", form.employee_id);
        formData.append("employee_name", form.employee_name);
        formData.append("designation", form.designation);
        if (form.department) {

            const department_id = form.department.id;
            formData.append("department", department_id);

        }
        formData.append("joining_date", form.joining_date);
        formData.append("contact_no", form.contact_no);
        formData.append("email", form.email);
        formData.append("password", form.password);
        formData.append("linkedin", form.linkedin);
        formData.append("nid", form.nid);
        formData.append("current_address", form.current_address);
        formData.append("permanent_address", form.permanent_address);
        formData.append("district", form.district);
        formData.append("police_station", form.police_station);
        formData.append("post_office", form.post_office);
        formData.append("village", form.village);
        formData.append("father", form.father);
        formData.append("mother", form.mother);
        if (form.avatar) {
            formData.append("avatar", form.avatar)
        }
        var url = route("admin.employee.store");
        if(employee){
            url = route('admin.employee.update',{employee:employee.id})
        }
        const { data } = await window.axios.post(url, formData);
        window.location.replace(route('admin.employee.index'));


    } catch (error) {
        console.error(error);
        const response = (error as any).response;
        if (response) {
            if (response.status == 422) {
                const data = response.data;
                const errors = data.errors as Record<string, string[]>;
                form.clearErrors();
                for (const key in errors) {
                    form.setError(key, head(errors[key]));
                }
            }
        }
    }

    busy.value = false;
}

const addImage = () => {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.click();

    input.addEventListener('change', () => {
        const files = input.files as any;

        if (files.length) {
            const file = files[0];
            const reader = new FileReader;
            form.avatar = file;
            reader.onload = () => {

                img.value = reader.result;
            }
            reader.readAsDataURL(file);
        } else {
            img.value = null;
            form.avatar = null
        }
    })


}


</script>



<style lang="scss" scoped>
@import 'sweetalert2/src/sweetalert2.scss';
</style>