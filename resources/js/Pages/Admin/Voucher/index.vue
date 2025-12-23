<template>
    <Layout :auth="auth">

        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Vouchers</h5>
            <Link class="btn btn-sm btn-primary" :href="route('admin.voucher.create')">
                <i class="bi bi-bookmark-plus"></i>
                <span class="mx-2">Create</span>
            </Link>
        </div>
        <main class="container-fluid">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Date</th>
                        <th class="text-left">Employee Name</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">
                            <i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in vouchers">
                        <td class=" text-center">{{ item.id }}</td>
                        <td class=" text-center">{{ item.date }}</td>
                        <td>{{ item.employee.employee_name }}</td>
                        <td class="text-end">{{ item.amount }}</td>
                        <td class="text-end">
                            <a class="btn btn-outline-info" :href="route('admin.voucher.show',{voucher:item.id})">PaySlip</a>
                            <button class="btn btn-outline-info" @click="showModel(item)">Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>

      <!-- Modal -->
        <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content relative">
                    <div class="model-header p-4">
                        <h3>{{ showV?.employee.employee_name }}</h3>
                    </div>
                    <div class="modal-body" v-if="showV">


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>PayHead</th>
                                    <th>Type</th>
                                    <th class="text-end">Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in showV.items">
                                    <td>{{ item.payhead.title }}</td>
                                    <td>{{ item.payhead.type }}</td>
                                    <td class="text-end">{{ item.amount }}</td>
                                    <td>{{ getBalance(showV.items,index) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ getTotal(showV.items) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                      
                    </div>
                    <div class="modal-footer">
                        <button 
                        @click="hideModel"
                        type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                        
                    </div>
                    <LoaderBox v-if="busy"></LoaderBox>
                </div>
            </div>
        </div>



    </Layout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
const { auth, vouchers } = defineProps<{ auth: Auth, vouchers: Voucher[] }>();
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

const showV = ref<Voucher | null>();

const showModel = (item:Voucher) => {
    showV.value = item;
    const bs = new bootstrap.Modal('#voucherModal');
    bs.show(document.body)
}
const hideModel = () => {
    const modal = bootstrap.Modal.getOrCreateInstance('#voucherModal');
    modal.hide();
}

const getTotal = (list:Voucher['items'])=>{
    return list.map(e=>{
        return e.payhead.type =='dedcution' ? e.amount *-1:e.amount;

    }).reduce((a,b)=>a+b,0)
}
const getBalance = (list:Voucher['items'],index:number)=>{

    return list.filter((e,i)=>i<=index).map(e=>{
        return e.payhead.type =='dedcution' ? e.amount *-1:e.amount;

    }).reduce((a,b)=>a+b,0)

}


</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>