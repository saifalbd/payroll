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
                    <div class="col-6" :class="{ 'invalid': !!form.errors.employee }">
                        <label class="form-label" for="">Employee</label>
                        <VueMultiselect :model-value="form.employee" @update:model-value="selectEmployee"
                            :options="employees" :searchable="false" :close-on-select="true" :allow-empty="false"
                            label="employee_name" placeholder="Select Employee" track-by="id"></VueMultiselect>
                        <div class="invalid-meessage">{{ form.errors.employee }}
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="">Date</label>
                        <input class="form-control" placeholder="Joining Date" v-model="form.date"
                            :class="{ 'is-invalid': !!form.errors.date }" type="date" />
                        <div class="invalid-feedback">{{ form.errors.date }}</div>
                    </div>
                    <div class="col-12">
                        <div class="custom-row">
                            <div>Payhead</div>
                             <div>Type</div>
                            <div>Amount</div>
                        </div>
                        <div class="custom-row" v-for="(item, index) in form.items">
                            <div class="" :class="{ 'invalid': !!form.errors[`items.${index}.payhead`] }">

                                <select class="form-select form-control-lg" :disabled="true"
                                :class="{ 'is-invalid': !!form.errors.payhead }" v-model="item.payhead" required>
                                <option v-for="op in payheads" :value="op.id">{{ op.title }}</option>
                            </select>
                            <div class="invalid-feedback">
                               {{ form.errors[`items.${index}.payhead`] }}
                            </div>
                            </div>
                            <div class=" capitalize text-center">
                                {{ item.type }}
                            </div>
                            <div class="">
                                <input class="form-control" placeholder="Amount" v-model="item.amount"
                                    :class="{ 'is-invalid': !!form.errors[`items.${index}.amount`] }" />
                                <div class="invalid-feedback">{{ form.errors[`items.${index}.amount`] }}</div>
                            </div>

                        </div>

                        <div class="col-12 text-end">
                            <button class="btn btn-primary">Save</button>
                        </div>

                    </div>
                </div>

            </div>
        </main>

    </Layout>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
import VueMultiselect from 'vue-multiselect'
const { auth, employees, payheads } = defineProps<{ auth: Auth, employees: Employee[], payheads: PayHead[] }>();

const form = useForm<any>({
    employee: null,
    date: null,
    items: [
       
    ]
})

const selectEmployee = async (emp: Employee) => {
    console.log(emp)


    try {
        const url = route('admin.voucher.findSalarySetup',{employee:emp.id});
        const {data} = await window.axios.get(url);
        
            form.employee = emp;
            const d = data as SalarySetup;

            d.items.forEach(item=>{
                const payhead = item.payhead.id;
                const amount = item.value;
                const type = item.payhead.type;
                form.items.push({
                    payhead,amount,type
                })

            })

            
    } catch (error:any) {
        console.error(error);
        if(error.response){
            const response = error.response;
            if(response.data){
                const message = response.data.message;
                alert(message)
            }

        }
        
    }


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