<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Salary Setups</a>
                <a type="button" class="btn btn-dark" :href="route('admin.salaryScale.create')">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </a>
            </div>
        </nav>
        <main class="container-fluid">
            <div v-for="item in salarySetups" class="my-2">

                <div class="card">
                    <div class="card-body">
                       
                        <div class="card-text">
                            <div class="row-grid">
                                <div>
                            
                                    <img  class="img-thumbnail" :src="item.employee.avatarUrl" alt="">
                                     <h5 class="card-title my-2 capitalize">{{ item.employee.employee_name }}</h5>
                                      <h5 class="card-sub-title my-2 capitalize">ID: {{ item.employee.employee_id }}</h5>
                                     <div>
                                        <a class=" btn btn-info btn-sm mx-1" :href="route('admin.salarySetup.edit',{salary_setup:item.id})">Edit</a>
                                         <button class=" btn btn-danger btn-sm mx-1">Delete</button>
                                     </div>
                                </div>
                                <div>
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
                </div>

            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">
import Layout from '../../../components/Layout.vue';
const { auth, salarySetups } = defineProps<{
    auth: Auth,
    salarySetups: SalarySetup[]
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
.row-grid{
    display: grid;
    grid-template-columns: 250px auto;
    img{
        width: 200px;
    }

}
</style>