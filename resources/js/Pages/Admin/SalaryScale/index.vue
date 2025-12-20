<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <h5 class="fw-bold ms-1" style="color: #e3342f">Salary Scales</h5>
                <a type="button" class="btn btn-dark" :href="route('admin.salaryScale.create')">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </a>
            </div>
        </nav>

        <main class="container-fluid">
            <div v-for="item in salaryScales" class="my-2">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ item.title }}</h5>
                        <div class="card-text">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>PayHead</th>
                                        <th>CalcType</th>
                                        <th>Rate</th>

                                        <th>Payhead For Calculation</th>
                                        <th>Formula</th>
                                        <th>Basis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="o in item.items">
                                        <td>{{ o.payhead.title }}</td>
                                        <td>{{ o.calc_type }}</td>
                                        <td>{{ o.value }}</td>
                                        <td>{{ o.parcent_of ? o.parcent_of.title : 'none' }}</td>
                                        <td>{{ o.formula }}</td>
                                        <td>{{ o.basis }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
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

  
  

})
</script>



<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>