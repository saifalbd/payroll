<template>
    <Layout :auth="auth">

        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Vouchers</h5>
            <Link  class="btn btn-sm btn-primary" :href="route('admin.voucher.create')">
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

        <!-- Modal -->
       


    </Layout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
const { auth} = defineProps<{ auth: Auth }>();
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


const busy = ref(false);



</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>