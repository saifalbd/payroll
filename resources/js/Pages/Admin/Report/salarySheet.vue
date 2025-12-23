<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-4" style="color: #e3342f">Salary Sheets</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="downloadExcel">
                <i class="bi bi-bookmark-plus"></i>
                <span class="mx-2">Excel</span>
            </button>

        </div>
        <main class="container-fluid">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Employee ID</th>
                        <th class="text-end" v-for="h in earnHeaders">{{ h.payheadName }}</th>
                        <th class="text-end">Total Earning</th>
                        <th class="text-end" v-for="h in dedcutionHeaders">{{ h.payheadName }}</th>
                        <th class="text-end">Total Deduction</th>
                        <th class="text-end">Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="v in vouchers">
                        <td>{{ v.employeName }}</td>
                        <td>{{ v.designation }}</td>
                        <td>{{ v.departmentName }}</td>
                        <td>{{ v.emp_id }}</td>
                        <td class="text-end" v-for="h in earnHeaders">{{ getAmount(h, v.list) }}</td>
                        <td class="text-end">{{ totalEarning(v.list) }}</td>
                        <td class="text-end" v-for="h in dedcutionHeaders">{{ getAmount(h, v.list) }}</td>
                        <td class="text-end">{{ totalDeduction(v.list) }}</td>
                        <td class="text-end">{{ netPay(v.list) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th class="text-end" v-for="h in earnHeaders">{{ sumBy(h.payhead_id) }}</th>
                        <th class="text-end">{{ grandEarn() }}</th>
                        <th class="text-end" v-for="h in dedcutionHeaders">{{ sumBy(h.payhead_id) }}</th>
                        <th class="text-end">{{ grandDeduction() }}</th>
                        <th class="text-end">{{ grandTotal() }}</th>
                    </tr>
                </tfoot>

            </table>
        </main>


    </Layout>
</template>

<script setup lang="ts">
import Layout from '@/components/Layout.vue';
import { sortBy, unionBy } from 'lodash';
import { ExportExcel } from './ExportExcel';

interface CustomVoucher {
    date: string
    emp_id: number
    employeName: string
    departmentName: string
    designation: string
    list: List[]
}

interface List {
    payheadName: string
    type: 'dedcution' | 'earning'
    amount: number
    payhead_id: number
}


const { auth, vouchers } = defineProps<{ auth: Auth, vouchers: CustomVoucher[] }>();
const headerList = sortBy(unionBy<List>(vouchers.map(e => e.list).flat(2), 'payhead_id'), 'type')

const earnHeaders = headerList.filter(e => e.type == 'earning');
const dedcutionHeaders = headerList.filter(e => e.type == 'dedcution');


const totalEarning = (list: List[]) => list.filter(e => e.type == 'earning').map(e => e.amount).reduce((a, b) => a + b, 0)
const totalDeduction = (list: List[]) => list.filter(e => e.type == 'dedcution').map(e => e.amount).reduce((a, b) => a + b, 0)
const netPay = (list: List[]) => list.map(e => e.amount).reduce((a, b) => a + b, 0)
const getAmount = (h: List, list: List[]): number | string => {
    const has = list.find(e => e.payhead_id == h.payhead_id);
    if (has) {
        return has.amount;
    } else {
        return 0;
    }
}

const grandEarn = () => vouchers.map(e => e.list).flat().filter(e => e.type == 'earning').map(e => e.amount).reduce((a, b) => a + b, 0);
const grandDeduction = () => vouchers.map(e => e.list).flat().filter(e => e.type == 'dedcution').map(e => e.amount).reduce((a, b) => a + b, 0);
const grandTotal = () => vouchers.map(e => e.list).flat().map(e => e.amount).reduce((a, b) => a + b, 0)
const sumBy = (payhead_id: number) => vouchers.map(e => e.list).flat().filter(e => e.payhead_id == payhead_id).map(e => e.amount).reduce((a, b) => a + b, 0)



const downloadExcel = () => {
    const headers = ['Name', 'Designation', 'Department', 'Employee ID'];

    earnHeaders.forEach(h => {
        headers.push(h.payheadName);
    });
    headers.push('Total Earning')
    dedcutionHeaders.forEach(h => {
        headers.push(h.payheadName);
    });
    headers.push('Total Deduction');
    headers.push('Net Pay');


    const list = vouchers.map(v => {
        const items: (string | number)[] = [v.employeName, v.designation, v.departmentName, v.emp_id];

        earnHeaders.forEach(h => {
            let val = getAmount(h, v.list);
            items.push(val);
        });
        items.push(totalEarning(v.list))
        dedcutionHeaders.forEach(h => {
            let val = getAmount(h, v.list);
            items.push(val);
        });
        items.push(totalDeduction(v.list))
        items.push(netPay(v.list))

        return items;

    });

    const footers:(string | number)[] = [
        'Total','','',''
    ]

      earnHeaders.forEach(h => {
      footers.push(sumBy(h.payhead_id));
    });
    footers.push(grandEarn())

     dedcutionHeaders.forEach(h => {
        footers.push(sumBy(h.payhead_id));
    });
    footers.push(grandDeduction())
    footers.push(grandTotal())

   

    const data = {headers,list,footers};
    const rep = new ExportExcel(data);
    rep.download()
    



}




</script>

<style scoped></style>