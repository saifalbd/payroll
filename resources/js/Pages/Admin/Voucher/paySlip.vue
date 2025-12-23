<template>
   <div class="payslip">
    <div class="container py-2 text-end d-print-none">
        <button class="btn btn-warning" @click="doPrint">
            <i class="bi bi-printer"></i>
            <span class="mx-4">Print</span>
            </button>
    </div>
     <div class="container mt-5 mb-5">
        
        <div class="row">
            <div class="col-md-12">
                <div class="text-center lh-1 mb-2">
                     <h2 class="fw-bold">{{ auth.companyName }}</h2>
                    <h3 class="fw-bold">Payslip</h3>
                   
                    <span class="fw-normal">Payment slip for the month of {{ month }}</span>
                </div>

                  <div class="base-info-row">
                            <div>
                                <ul class="base-info">
                                    <li> <i class="bi bi-calendar"></i>
                                        <span class="mx-1">Date Of Joining:</span>
                                        </li>
                                    <li>{{ joining_date }}</li>
                                </ul>
                                <ul class="base-info">
                                    <li><i class="bi bi-recycle"></i>
                                    <span class="mx-1">Pay Period:</span>
                                    </li>
                                    <li>{{ month}}</li>
                                </ul>
                                <ul class="base-info">
                                    <li><i class="bi bi-pc-display-horizontal"></i> <span class="mx-1">Working Days:</span></li>
                                    <li>{{ voucher.employee.joining_date }}</li>
                                </ul>
                            </div>
                                <div >
                                <ul class="base-info">
                                    <li><i class="bi bi-person"></i> <span class="mx-1">Employee Name:</span></li>
                                    <li>{{ voucher.employee.employee_name }}</li>
                                </ul>
                                <ul class="base-info">
                                    <li><i class="bi bi-app-indicator"></i> <span class="mx-1">Employee ID:</span></li>
                                    <li>{{ voucher.employee.employee_id }}</li>
                                </ul>
                                <ul class="base-info">
                                    <li><i class="bi bi-window-dock"></i> <span class="mx-1">Designation:</span></li>
                                    <li>{{ voucher.employee.designation }}</li>
                                </ul>
                                <ul class="base-info">
                                    <li><i class="bi bi-buildings"></i><span class="mx-1">Department:</span></li>
                                    <li>{{ voucher.employee.department.name }}</li>
                                </ul>
                            </div>
                        </div>
                
                <div class="row">
                    
                    <div class="col-md-10">

                      



                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Earnings</th>
                                <th class="text-end">Amount</th>
                                <th>Deductions</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items">
                                <th scope="row">{{ item.earnTitle }}</th>
                                <td class="text-end">{{ currency(item.earnValue)  }}</td>
                                <td>{{ item.dedcutionTitle }}</td>
                                <td class="text-end">{{  currency(item.dedcutionValue) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Total Earning</th>
                                <th  class="text-end">{{  currency(totalEarn) }}</th>
                                <th>Total Deductions</th>
                                <th class="text-end">{{  currency(totalDeduction) }}</th>
                            </tr>

                            <tr>
                                <td colspan="2"></td>
                                <th>Net Pay</th>
                                <th  class="text-end">{{  currency(netPay) }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">

                    <div class="border col-md-12">
                        <div class="d-flex flex-column"> <span>In Words</span> <span>{{ inWord(netPay) }} only</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="d-flex flex-column mt-2"> <span class="fw-bolder">For {{ auth.companyName }}</span>
                        <span class="mt-4">Authorised Signatory</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</template>

<script setup lang="ts">
import moment from 'moment';
import { ToWords } from 'to-words';
import { reactive } from 'vue';
import formatter from 'currency-formatter';
type TableItem = {
    earnTitle: string
    earnValue: number | null
    dedcutionTitle: string
    dedcutionValue: number | null
}


const { auth, voucher } = defineProps<{
    auth: Auth,
    voucher: Voucher
}>();

const month = moment().format('MMMM YYYY');
const joining_date = moment(voucher.employee.joining_date).format('MMMM Do YYYY');


const earns = voucher.items.filter(e => e.payhead.type == 'earning');
const dedcutions = voucher.items.filter(e => e.payhead.type == 'dedcution');
const items = reactive<TableItem[]>(earns.map((item, index) => {
    const data: TableItem = {
        earnTitle: item.payhead.title,
        earnValue: item.amount,
        dedcutionTitle: '',
        dedcutionValue: null
    };
    if (index < dedcutions.length) {
        const has = dedcutions[index];
        if (has) {
            data['dedcutionTitle'] = has.payhead.title;
            data['dedcutionValue'] = has.amount;
        }
    }

    return data;

}));

const totalEarn = earns.map(e => e.amount).reduce((a, b) => a + b, 0);
const totalDeduction = dedcutions.map(e => e.amount).reduce((a, b) => a + b, 0);
const netPay = voucher.items.map(e => e.amount).reduce((a, b) => a + b, 0);

const inWord = (netPay: number) => (new ToWords()).convert(netPay)

const doPrint = ()=>{
    window.print()
}

const currency = (val:number | null)=>{
    return val? formatter.format(val,{ code: 'BDT' }) : val;
}


</script>

<style lang="scss" scoped>

</style>