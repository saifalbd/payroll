<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Salary Scales</h5>
            <Link type="button" class="btn btn-sm btn-primary" :href="route('admin.salaryScale.create')">
                <i class="bi bi-bookmark-plus"></i>
                <span class="mx-2">Create</span>
            </Link>
        </div>
        <main class="container-fluid">
            <DataTable ref="table" :columns="columns" :data="salaryScales" :options="options"
                class="table table-striped table-hover nowrap">
            </DataTable>
        </main>
    </Layout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
const { auth, salaryScales } = defineProps<{
    auth: Auth,
    salaryScales: SalaryScale[]
}>();
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import { onMounted, ref } from 'vue';
DataTable.use(DataTablesCore);
const columns = [
        {
            className: 'dt-control',
            orderable: false,
            data: null,
             defaultContent: '<i class="bi bi-caret-down-square"></i>'
        },
        
    { data: 'title', title: 'Title' },

];
let dt;
const options = {
    paging: false,

}

const table = ref<HTMLElement>();
onMounted(() => {

  dt = table.value.dt;
  console.log(dt.body())

})
</script>



<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>