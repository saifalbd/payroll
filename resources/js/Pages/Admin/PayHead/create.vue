<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Create Employee</a>
                <a type="button" class="btn btn-dark" :href="route('admin.department.index')">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Back</span>
                </a>
            </div>
        </nav>
        <main class="container-fluid">
            <div class="container relative">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label" for="">Name</label>
                        <input class="form-control" placeholder="Name" v-model="form.name"
                            :class="{ 'is-invalid': !!form.errors.name }" />
                        <div class="invalid-feedback">{{ form.errors.name }}</div>
                    </div>



                    <div class="col-12 text-end my-4">
                        <button class="btn btn-dark" @click="save"><i class="bi bi-save2"></i> <span
                                class="mx-2">Save</span></button>
                    </div>



                </div>
                <LoaderBox v-if="busy"></LoaderBox>
            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
import Swal from 'sweetalert2'
import { ref } from "vue";
import LoaderBox from "../../../components/LoaderBox.vue";
import { route } from "ziggy-js";
const { auth } = defineProps<{
    auth: Auth

}>();

const busy = ref(false)

const form = useForm<any>({

    name: null,

})




const save = async () => {



    //   busy.value = true;
    try {


        form.post(route('admin.department.store'))



    } catch (error) {
        console.error(error);

    }

    //  busy.value = false;
}




</script>



<style lang="scss" scoped>
@import 'sweetalert2/src/sweetalert2.scss';
</style>