<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Salary Setup</h5>
            <Link type="button" class="btn btn-sm btn-primary" :href="route('admin.salarySetup.create')">
                <i class="bi bi-bookmark-plus"></i>
                <span class="mx-2">Create</span>
            </Link>
        </div>
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
                   
                </tbody>
            </DataTable>
        </main>
    </Layout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
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