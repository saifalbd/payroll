<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Departments</a>
                <a type="button" class="btn btn-dark" @click="doCreate()">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </a>
            </div>
        </nav>
        <main class="container-fluid">
            <DataTable :options="options" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class=" text-left">Name</th>
                        <th class="text-center">
                            <i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in departments">
                        <td class=" text-center">{{ item.id }}</td>
                        <td class="text-left">{{ item.name }}</td>
                        <td class="text-center">
                            <div class=" d-flex justify-content-center">
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li><a class="dropdown-item" @click="doEdit(item)">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="mx-2">Edit</span>
                                            </a></li>


                                        <li><a class="dropdown-item" @click="remove(item)">
                                                <i class="bi bi-trash"></i>
                                                <span class="mx-2">Delete</span>
                                            </a></li>

                                    </ul>
                                </div>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </DataTable>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content  relative">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header bg-dark-light  text-center p-2">
                                    <h2>{{ formTitle }}</h2>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="">Name</label>
                                <input class="form-control form-control-lg" placeholder="Name" v-model="form.name"
                                    :class="{ 'is-invalid': !!form.errors.name }" />
                                <div class="invalid-feedback">{{ form.errors.name }}</div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                        <button type="button" class="btn btn-info" @click="save">
                            <i class="bi bi-save2"></i>
                            <span class="mx-2">Save</span>
                        </button>
                    </div>
                    <LoaderBox v-if="busy"></LoaderBox>
                </div>
            </div>
        </div>


    </Layout>
</template>

<script setup lang="ts">
import Layout from '../../../components/Layout.vue';
const { auth, departments } = defineProps<{ auth: Auth, departments: Department[] }>();
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import { deleteConfirm, deleteError } from '@/utility';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { head } from 'lodash';
import LoaderBox from '@/components/LoaderBox.vue';
DataTable.use(DataTablesCore);
const bootstrap = inject<any>('bootstrap');

const options = {
    paging: false
}

const formTitle = ref('Add Department');
const busy = ref(false);

const form = useForm<any>({
    id: null,
    name: ''
});


const showModel = () => {
    const bs = new bootstrap.Modal('#departmentModal');
    bs.show(document.body)
}
const hideModel = () => {
    const modal = bootstrap.Modal.getOrCreateInstance('#departmentModal');
    modal.hide();
}

const doCreate = () => {
    formTitle.value = 'Add Department';
    showModel();

}
const doEdit = (item: Department) => {
    formTitle.value = `Edit Department: ${item.name}`;
    form.name = item.name;
    form.id = item.id;
    showModel()

}


const save = async () => {
    try {

        if (form.id) {
            const url = route('admin.department.update', { department: form.id });
            await window.axios.put(url, { name: form.name });
        } else {
            const url = route('admin.department.store');
            await window.axios.post(url, { name: form.name });
        }
        location.reload()

        hideModel()


    } catch (error) {
        console.error(error);
        const response = (error as any).response;
        if (response) {
            if (response.status == 422) {
                const data = response.data;
                const errors = data.errors as Record<string, string[]>;
                form.clearErrors();
                let key: string
                for (key in errors) {
                    (form as any).setError(key, head(errors[key]));
                }
            }
        }
    }
}

const remove = async (item: Department) => {
    const is = await deleteConfirm(``);
    if (!is) return;
    try {
        const url = route('admin.department.destroy', { department: item.id });
        await window.axios.delete(url);
    } catch (error) {
        console.error(error);
        deleteError(error)
    }
}
</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>