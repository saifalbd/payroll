<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-4" style="color: #e3342f">Create Salary Scales</h5>
            <Link type="button" class="btn btn-sm btn-primary me-4" :href="route('admin.salaryScale.index')">
                <i class="bi bi-arrow-left"></i>
                <span class="mx-2">Back</span>
            </Link>
        </div>
        <main class="container-fluid">
            <div class="container relative">
                <div class="row">

                    <div class="col-12">
                        <label class="form-label" for="">Pay Scale Name</label>
                        <input class="form-control" placeholder="Name" v-model="form.title"
                            :class="{ 'is-invalid': !!form.errors.title }" />
                        <div class="invalid-feedback">{{ form.errors.title }}</div>
                    </div>

                    <div class="col-12">
                        <table class="w-full">
                            <thead>
                                <th>Payhead</th>
                                <th>Calc Type</th>
                                <th>Rate</th>
                                <th>Payhead for Calculation</th>
                                <th>Operator</th>
                                <th>Basis</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in form.items">
                                    <td :class="{ 'invalid': !!form.errors[`items.${index}.payhead_id`] }"
                                        style="min-width: 200px;">
                                        <VueMultiselect v-model="item.payhead" :options="payheads" :searchable="false"
                                            :close-on-select="true" :allow-empty="false" label="text"
                                            placeholder="Select one" track-by="text"></VueMultiselect>
                                        <div class="invalid-meessage">{{ form.errors[`items.${index}.payhead_id`] }}
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-select" :value="item.calc_type"
                                            @change="changeCalc($event, item)"
                                            :class="{ 'is-invalid': !!form.errors[`items.${index}.calc_type`] }">
                                            <option v-for="op in calc_types" :value="op.value">{{ op.text }}</option>
                                        </select>
                                        <div class="invalid-feedback">{{ form.errors[`items.${index}.calc_type`] }}
                                        </div>
                                    </td>
                                    <td>
                                        <input class="form-control" placeholder="Rate" :value="item.value"
                                            @change="addRate($event, item)"
                                            :class="{ 'is-invalid': !!form.errors[`items.${index}.value`] }"
                                            :disabled="item.isPercent" />
                                        <div class="invalid-feedback">{{ form.errors[`items.${index}.value`] }}</div>
                                    </td>
                                    <td :class="{ 'invalid': !!form.errors[`items.${index}.parcentOf`] }">
                                        <VueMultiselect :model-value="item.parcentOf"
                                            @update:model-value="changeParcentOf($event, item)" :options="payheads"
                                            :searchable="false" :close-on-select="true" :allow-empty="false"
                                            label="text" placeholder="Select one" track-by="text"
                                            :disabled="!item.isPercent"></VueMultiselect>
                                        <div class="invalid-meessage">{{ form.errors[`items.${index}.parcentOf`] }}
                                        </div>
                                    </td>
                                    <td>

                                        <select class="form-select" :value="item.formula"
                                            @change="changeOparetor($event, item)"
                                            :class="{ 'is-invalid': !!form.errors[`items.${index}.formula`] }"
                                            :disabled="!item.isPercent">
                                            <option v-for="op in formulas" :value="op.value">{{ op.text }}</option>
                                        </select>
                                        <div class="invalid-feedback">{{ form.errors[`items.${index}.formula`] }}</div>
                                    </td>
                                    <td>
                                        <input class="form-control" placeholder="Basis" :model-value="item.basis"
                                            @change="changeBasis($event, item, index)"
                                            :class="{ 'is-invalid': !!form.errors[`items.${index}.basis`] }"
                                            :disabled="!item.isPercent" />
                                        <div class="invalid-feedback">{{ form.errors[`items.${index}.basis`] }}</div>
                                    </td>
                                    <td class="pt-2">
                                        <div class="me-2 mt-0">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                @click="clickAdd">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm ms-1"
                                                @click="clickRemove(index)">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-12 text-end my-4">
                        <button class="btn btn-success" @click="save"><i class="bi bi-save2"></i> <span
                                class="mx-2">Save</span></button>
                    </div>



                </div>
                <LoaderBox v-if="busy"></LoaderBox>
            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import Layout from '../../../components/Layout.vue';
import VueMultiselect from 'vue-multiselect'
import { onMounted, reactive, ref } from "vue";
import LoaderBox from "../../../components/LoaderBox.vue";
import { route } from "ziggy-js";
import { head, replace } from 'lodash';

const { auth } = defineProps<{
    auth: Auth

}>();


type Dropdown = {
    text: string,
    value: string | number
}

type CalcType = 'formula' | 'flat';

type Item = {
    calc_type: CalcType
    value: null | number
    payhead: null | Dropdown
    formula: string
    isPercent: boolean
    parcentOf: Dropdown | null
    basis: string
}

const busy = ref(false)

const calc_types = reactive([
    {
        value: 'formula',
        text: 'Formula'
    },
    {
        value: 'flat',
        text: 'Flat'
    },
]);
const formulas = reactive([
    {
        value: '*',
        text: 'Multiplication (x)'
    },
    {
        value: '/',
        text: 'Division (/)'
    },
    {
        value: '+',
        text: 'Addition (+)'
    },
    {
        value: '-',
        text: 'Subtraction (-)'
    },
])


const payheads = ref([])
const form = useForm<{ title: string | null, items: Item[] }>({

    title: null,
    items: [
        {
            calc_type: 'flat',
            value: null,
            payhead: null,
            formula: formulas[2].value,
            isPercent: false,
            parcentOf: null,
            basis: ''
        }
    ]

})



const loadPayheads = async () => {
    try {
        const url = route('admin.payhead.dropdowns', { company_id: auth.company_id });
        const { data } = await window.axios.get(url);
        payheads.value = data.map((item: any) => {
            return {
                value: item.id,
                text: item.title
            }
        })

    } catch (error) {
        console.error(error);
    }
}



const save = async () => {



    const is = form.hasErrors;
    if (is) return null;

    busy.value = true;
    try {

        const list = form.items.map(item => {
            const calc_type = item.calc_type ? item.calc_type : null;
            const payhead_id = item.payhead ? item.payhead.value : null;
            const value = item.value;
            const formula = item.formula ? item.formula : null;
            const parcent_of_id = item.parcentOf ? item.parcentOf.value : null;
            const basis = item.basis;
            return {
                calc_type, payhead_id, value, formula, parcent_of_id, basis
            }
        });

        const url = route('admin.salaryScale.store');
        await window.axios.post(url, { title: form.title, items: list })
        window.location.replace(route('admin.salaryScale.index'));
    } catch (error) {
        console.error(error);
        const response = (error as any).response;
        if (response) {
            if (response.status == 422) {
                const data = response.data;
                const errors = data.errors as Record<string, string[]>;
                form.clearErrors();
                for (const key in errors) {
                    form.setError(key, head(errors[key]));
                }
            }
        }

    }

    busy.value = false;
}



/* START CHANGE INPUT */
const clickAdd = () => {
    form.items.push(
        {
            calc_type: 'flat',
            value: null,
            payhead: null,
            formula: formulas[2].value,
            isPercent: false,
            parcentOf: null,
            basis: ''
        }
    )

}
const clickRemove = (index: number) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1)
    }

}

const changeCalc = (event: Event, item: Item) => {
    form.clearErrors()
    const { value } = event.target as HTMLSelectElement;
    if (value) {
        const isPercent = value == 'formula';
        item.isPercent = isPercent;
        if (!isPercent) {
            item.parcentOf = null;
            item.basis = ''
        }
    } else {
        item.isPercent = false;
        item.parcentOf = null;
        item.basis = '';
    }
    item.calc_type = value as CalcType;
}
const changeOparetor = (event: Event, item: Item) => {
    form.clearErrors()
    const { value } = event.target as HTMLSelectElement;
    item.formula = value;
    form.items.forEach((o, index) => {
        if (o.calc_type == 'formula') {
            applyBasis(o, index)
        }

    });
}

const changeParcentOf = (val: Dropdown, item: Item) => {
    form.clearErrors()
    item.parcentOf = val;


    if (item.payhead?.value)

        if (item.calc_type != 'flat') {
            form.items.forEach((o, index) => {
                if (o.calc_type == 'formula') {
                    applyBasis(o, index)
                }
            });
        };

}
const addRate = (event: Event, item: Item) => {
    form.clearErrors();
    const { value } = event.target as HTMLSelectElement;
    item.value = parseInt(value);
    form.items.forEach((o, index) => {
        if (o.calc_type == 'formula') {
            applyBasis(o, index)
        }
    });
}

const applyBasis = (item: Item, index: number) => {
    const { basis, calc_type, parcentOf } = item;
    try {

        if (calc_type == 'flat') throw 'Calc type is flat';

        if (calc_type == 'formula') {
            console.log({ ...item, index })
            if (!basis) {
                form.setError(`items.${index}.basis`, 'Basis is invalid');
                throw 'Basis is invalid';
            }
        }


        if (!parcentOf) {
            form.setError(`items.${index}.parcentOf`, 'should be required');
            throw 'Pay Head for Calculation in required'
        };
        if (!item.formula) {
            form.setError(`items.${index}.formula`, 'should be required');
            throw ' Formula is required';
        }
        let val = item.basis;
        const formula = item.formula;
        var hasVal = 0;
        const has = form.items.filter((e, i) => index != i).find(e => e.payhead && e.payhead.value == parcentOf.value);
        if (has) {
            if (!has.value) throw `Pay Head for Calculation Base Payhead ${parcentOf.text} Rate are invalid not found`;
            hasVal = has.value;
        } else {
            form.setError(`items.${index}.parcentOf`, 'selected invalid');
            throw `Pay Head for Calculation Base Payhead ${parcentOf.text} not found`;
        }
        var itemVal = 0;
        if (val.search('%') > -1) {
            let v = replace(val, '%', '');
            let digit = parseFloat(v);
            const sum = (hasVal / 100);
            if (formula == '+') {
                itemVal = sum + digit;
            } else if (formula == '-') {
                itemVal = sum - digit;
            } else if (formula == '/') {
                itemVal = sum / digit;
            } else if (formula == '*') {
                itemVal = sum * digit;
            }
        } else {
            let digit = parseFloat(val);
            if (formula == '+') {
                itemVal = hasVal + digit;
            } else if (formula == '-') {
                itemVal = hasVal - digit;
            } else if (formula == '/') {
                itemVal = hasVal / digit;
            } else if (formula == '*') {
                itemVal = hasVal * digit;
            }
        }
        item.value = itemVal;

    } catch (error) {
        console.error(error)
    }
}

const changeBasis = (event: Event, item: Item, index: number) => {
    const { value } = event.target as HTMLSelectElement;
    form.clearErrors();
    if (item.calc_type != 'formula') return;

    if (!value) {
        form.setError(`items.${index}.basis`, 'Basis is invalid');
        return;
    }


    if (value.search('%') > -1) {
        let v = replace(value, '%', '');
        let digit = parseFloat(v);

        if (!digit) {
            form.setError(`items.${index}.basis`, 'Basis is invalid');
            return
        }
    } else {
        let digit = parseFloat(value);
        if (!digit) {
            form.setError(`items.${index}.basis`, 'Basis is invalid');
        }
    }



    item.basis = value;
    applyBasis(item, index)

}
/* END CHANGE INPUT */


onMounted(() => {
    loadPayheads()
})

</script>



<style lang="scss" scoped>
.w-full {
    width: 100%;
    margin-top: 10px;

    thead {
        th {
            padding: 5px;
        }
    }

    tbody {
        td {
            vertical-align: baseline;
            padding: 5px;
        }
    }
}
</style>