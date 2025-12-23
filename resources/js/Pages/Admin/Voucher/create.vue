<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-4" style="color: #e3342f">Create Voucher</h5>
            <Link type="button" class="btn btn-sm btn-primary me-4" :href="route('admin.salarySetup.index')">
                <i class="bi bi-arrow-left"></i>
                <span class="mx-2">Back</span>
            </Link>
        </div>

        <main class="container-fluid">
            <div class="container relative">

                <div class="row">
                    <div class="col-12 offset-md-6 col-md-6">
                        <div class="input-group input-group-lg mb-3">
                            <span class="input-group-text" id="basic-addon1">Date:</span>
                            <input type="date" :value="inputDate" @change="absentCount" class="form-control"
                                placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>

                <div v-show="inputDate" class="card my-2" v-for="item in list">
                    <div class="card-header">
                        {{ item.employee_name }}
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Payhead</th>
                                    <th>Type</th>
                                    <th class=" text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="o in item.salary_setup.items">
                                    <td>{{ o.payhead.title }}</td>
                                    <td>{{ o.payhead.type }}</td>
                                    <td class=" text-end">{{ o.value }}</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th class=" text-end">{{ item.total }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end" v-if="inputDate">
                    <button class="btn btn-success btn-lg" @click="save">
                        <i class="bi bi-save2"></i>
                        <span class="mx-4">Save</span>
                    </button>
                </div>

                <LoaderBox v-if="busy"></LoaderBox>

            </div>
        </main>

    </Layout>
</template>

<script setup lang="ts">
import LoaderBox from "../../../components/LoaderBox.vue";
import { Link } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
import { reactive, ref } from "vue";
import { sum } from "lodash";
import moment from "moment";
interface EmployeeType extends Employee {
    total: number
}
const { auth, employees } = defineProps<{ auth: Auth, employees: EmployeeType[], payheads: PayHead[] }>();

const busy = ref(false);

const inputDate = ref('')


const setTotal = (item:EmployeeType) =>{
   const earning = sum(item.salary_setup.items.filter(e => e.payhead.type == 'earning').map(e => e.value));
    const dedcution = sum(item.salary_setup.items.filter(e => e.payhead.type == 'dedcution').map(e => e.value));
    const total = earning - dedcution;
    item.total = total;
    return item;
}
const list = reactive(employees.map(item =>setTotal(item)))

const absentCount = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const val = target.value;
    inputDate.value = val;
    try {
        const month = moment(val).format('YYYY-MM')


        for (const key in employees) {
            let emp = employees[key];
            const employee_id = emp.id;
            const has = emp.salary_setup.items.find(e => e.calc_type == 'attendance');
            if (has) {
                const url = route('admin.voucher.absentCount',{month,employee_id})
                const {data} = await window.axios.get(url);
                const count = data?data:0;
                has.value = count*has.value;
               
                setTotal(emp)


            }


        }



    } catch (error) {
        console.error(error);
    }
}
const save = async () => {
    const date = inputDate.value;
    if (!date) {
        alert('Date not assigned')
        return null;
    }
    busy.value = true;
    try {
        const url = route('admin.voucher.store');
        const items = employees.map(item => {
            const employee_id = item.id;
            const total = item.total;

            const items = item.salary_setup.items.map(o => {
                const payhead = o.payhead_id;
                const amount = o.value;
                return { payhead, amount }
            });
            return { employee_id, total, date, items }
        });
        await window.axios.post(url, { items });
        window.location.replace(route('admin.voucher.index'));
    } catch (error) {
        console.error(error);
    }
    busy.value = false;
}

</script>

<style lang="scss" scoped>
.custom-row {
    padding-bottom: 5px;
    display: grid;
    grid-gap: 5px;
    grid-template-columns: 1fr 100px 1fr;
}
</style>