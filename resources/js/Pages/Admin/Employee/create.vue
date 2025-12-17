<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-4" style="color: #e3342f">Create Employee</h5>
            <Link type="button" class="btn btn-sm btn-primary me-4" :href="route('admin.employee.index')">
                <i class="bi bi-arrow-left"></i>
                <span class="mx-2">Back</span>
            </Link>
        </div>

        <main>
            <div class="container relative">
                <div class="row gap-custom">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input class="form-control" placeholder="Employee ID" v-model="form.employee_id"
                                   :class="{ 'is-invalid': !!form.errors.employee_id }" />
                            <div class="invalid-feedback">{{ form.errors.employee_id }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input class="form-control" placeholder="Name" v-model="form.employee_name"
                                   :class="{ 'is-invalid': !!form.errors.employee_name }" />
                            <div class="invalid-feedback">{{ form.errors.employee_name }}</div>
                        </div>

                        <div>
                            <label class="form-label">Designation</label>
                            <input class="form-control" placeholder="Designation" v-model="form.designation"
                                   :class="{ 'is-invalid': !!form.errors.designation }" />
                            <div class="invalid-feedback">{{ form.errors.designation }}</div>
                        </div>
                    </div>

                    <!-- Right side image -->
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <div class="card" style="width: 18rem;">
                            <img :src="img" class="card-img-top" alt="">
                            <div class="card-body text-center">
                                <button type="button" class="btn btn-dark" @click="addImage">
                                    {{ img ? 'Replace Image' : 'Insert Image' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <VueMultiselect :model-value="form.department" :options="departments" :searchable="false"
                                        :close-on-select="false" :allow-empty="false" @update:model-value="updateSelected"
                                        label="name" placeholder="Select one" track-by="name"></VueMultiselect>
                        <div class="invalid-feedback">{{ form.errors.department }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Joining Date</label>
                        <input class="form-control" type="date" placeholder="Joining Date" v-model="form.joining_date"
                               :class="{ 'is-invalid': !!form.errors.joining_date }" />
                        <div class="invalid-feedback">{{ form.errors.joining_date }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact No</label>
                        <input class="form-control" placeholder="Contact no" v-model="form.contact_no"
                               :class="{ 'is-invalid': !!form.errors.contact_no }" />
                        <div class="invalid-feedback">{{ form.errors.contact_no }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NID No.</label>
                        <input class="form-control" placeholder="NID" v-model="form.nid"
                               :class="{ 'is-invalid': !!form.errors.nid }" />
                        <div class="invalid-feedback">{{ form.errors.nid }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control" placeholder="Email" v-model="form.email"
                               :class="{ 'is-invalid': !!form.errors.email }" />
                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Login Password</label>
                        <input class="form-control" placeholder="Login Password" v-model="form.password"
                               :class="{ 'is-invalid': !!form.errors.password }" />
                        <div class="invalid-feedback">{{ form.errors.password }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Current Address</label>
                        <input class="form-control" placeholder="Current Address" v-model="form.current_address"
                               :class="{ 'is-invalid': !!form.errors.current_address }" />
                        <div class="invalid-feedback">{{ form.errors.current_address }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Permanent Address</label>
                        <input class="form-control" placeholder="Permanent Address" v-model="form.permanent_address"
                               :class="{ 'is-invalid': !!form.errors.permanent_address }" />
                        <div class="invalid-feedback">{{ form.errors.permanent_address }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">LinkedIn</label>
                        <input class="form-control" placeholder="LinkedIn" v-model="form.linkedin"
                               :class="{ 'is-invalid': !!form.errors.linkedin }" />
                        <div class="invalid-feedback">{{ form.errors.linkedin }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">District</label>
                        <input class="form-control" placeholder="District" v-model="form.district"
                               :class="{ 'is-invalid': !!form.errors.district }" />
                        <div class="invalid-feedback">{{ form.errors.district }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Police Station</label>
                        <input class="form-control" placeholder="Police Station" v-model="form.police_station"
                               :class="{ 'is-invalid': !!form.errors.police_station }" />
                        <div class="invalid-feedback">{{ form.errors.police_station }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Post Office</label>
                        <input class="form-control" placeholder="Post Office" v-model="form.post_office"
                               :class="{ 'is-invalid': !!form.errors.post_office }" />
                        <div class="invalid-feedback">{{ form.errors.post_office }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Village/Road</label>
                        <input class="form-control" placeholder="Village/Road" v-model="form.village"
                               :class="{ 'is-invalid': !!form.errors.village }" />
                        <div class="invalid-feedback">{{ form.errors.village }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Father</label>
                        <input class="form-control" placeholder="Father" v-model="form.father"
                               :class="{ 'is-invalid': !!form.errors.father }" />
                        <div class="invalid-feedback">{{ form.errors.father }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mother</label>
                        <input class="form-control" placeholder="Mother" v-model="form.mother"
                               :class="{ 'is-invalid': !!form.errors.mother }" />
                        <div class="invalid-feedback">{{ form.errors.mother }}</div>
                    </div>

                    <div class="col-12 text-center my-4 px-4">
                        <button class="btn btn-success w-100" @click="save">Save</button>
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
import { Link } from '@inertiajs/vue3';

const { auth } = defineProps<{
    auth: Auth
    departments: any

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






        const url = route("admin.employee.store");
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

.gap-custom .col-md-6 {
    margin-bottom: 1rem; // Adjust the value as needed
    padding-right: 2rem;
    padding-left: 2rem;
}
    
</style>