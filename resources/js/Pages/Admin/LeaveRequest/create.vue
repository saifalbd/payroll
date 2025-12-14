<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <a type="button" class="btn btn-primary">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </a>
            </div>
        </nav>
        <main class="container-fluid">
            <div class="container">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Leave Type</label>
                            <select class="form-select form-control-lg"
                                :class="{ 'is-invalid': !!form.errors.leaveType }" v-model="form.leaveType" required>
                                <option selected disabled>Select leave type</option>
                                <option>Casual Leave</option>
                                <option>Sick Leave</option>
                                <option>Annual Leave</option>
                                <option>Maternity / Paternity Leave</option>
                                <option>Emergency Leave</option>
                            </select>
                            <div class="invalid-feedback">
                                {{ form.errors.dates }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <VueDatePicker v-model="form.dates" multiDates model-type="yyyy-MM-dd"
                            :time-config="{ enableTimePicker: false }" />

                        <div class="invalid-feedback">
                            {{ form.errors.dates }}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input v-model="form.subject" type="text" class="form-control form-control-lg"
                                :class="{ 'is-invalid': !!form.errors.subject }" required>
                            <div class="invalid-feedback">
                                {{ form.errors.subject }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Reason for Leave</label>
                            <textarea v-model="form.message" class="form-control form-control-lg" rows="3"
                                placeholder="Write your reason" :class="{ 'is-invalid': !!form.errors.message }"
                                required></textarea>
                            <div class="invalid-feedback">
                                {{ form.errors.message }}
                            </div>
                        </div>
                    </div>

                    <div class="offset-3 col-6">
                        <button type="button" class="btn btn-primary btn-lg w-100" @click="save">
                            <i class="bi bi-file-plus"></i>
                            <span class="mx-2">Submit Leave Request</span>
                        </button>
                    </div>

                </div>
            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">



import { VueDatePicker } from "@vuepic/vue-datepicker"
import { useForm } from '@inertiajs/vue3';
import moment from 'moment'
import Layout from '../../../components/Layout.vue';
import Swal from 'sweetalert2'
const { auth } = defineProps<{
    auth: Auth,

}>();

const form = useForm({
    dates: [
        "2025-12-09",
        "2025-12-11"
    ],
    leaveType: "Annual Leave",
    subject: "leave subject",
    message: "leave subject resion"
})



const save = () => {

    form.post(route('leaveApp.store'));

}


</script>



<style lang="scss" scoped>
@import 'sweetalert2/src/sweetalert2.scss';
</style>