<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Departments</a>
                <a type="button" class="btn btn-dark" :href="route('admin.department.create')">
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

                                        <li><a class="dropdown-item" href="#">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="mx-2">Edit</span>
                                            </a></li>


                                        <li><a class="dropdown-item" href="#">
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
    </Layout>
</template>

<script setup lang="ts">
import Layout from '../../../components/Layout.vue';
const { auth, departments } = defineProps<{ auth: Auth, departments: Department }>();
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
DataTable.use(DataTablesCore);


const options = {
    paging: false
}
</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>