<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand">Payheads</a>
                <button type="button" class="btn btn-dark" @click="showModel">
                    <i class="bi bi-bookmark-plus"></i>
                    <span class="mx-2">Create</span>
                </button>
            </div>
        </nav>
        <main class="container-fluid">
            <DataTable :options="options" class="table table-striped table-hover nowrap">
                <thead>
                    <tr>
                        <th class="text-left">Title</th>
                        <th class="text-left">Type</th>
                        <th class="text-left">Ledger</th>
                        <th class="text-center">
                            <i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in payheads">
                        <td class="text-left  capitalize">{{ item.title }}</td>
                        <td class="text-left  capitalize">{{ item.type }}</td>
                        <td class="text-left capitalize">{{ item.ledger.title }}</td>
                        <td class="text-center">
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="mx-2">Edit</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-trash"></i>
                                            <span class="mx-2">Delete</span>
                                        </a></li>

                                </ul>
                            </div>
                        </td>
                        </td>

                    </tr>
                </tbody>


            </DataTable>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="payheadModal" tabindex="-1" aria-labelledby="payheadModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content  relative">
                   
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header bg-dark-light  text-center p-2">
                                    <h2>Add Payheads</h2>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="">Name</label>
                                <input class="form-control form-control-lg" placeholder="Name" v-model="form.name"
                                    :class="{ 'is-invalid': !!form.errors.name }" />
                                <div class="invalid-feedback">{{ form.errors.name }}</div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="">Type</label>

                                <select class="form-select form-select-lg" :value="form.type" @change="selectType"
                                    :class="{ 'is-invalid': !!form.errors.type }">
                                    <option v-for="op in types" :value="op.value">{{ op.text }}</option>

                                </select>
                                <div class="invalid-feedback">{{ form.errors.type }}</div>
                            </div>
                            <div class="col-lg-12" :class="{ 'invalid': !!form.errors.ledger }">
                                <label class="form-label" for="">Ledger</label>

                                <VueMultiselect :model-value="form.ledger" :options="ledgers" :searchable="false"
                                    :close-on-select="true" :allow-empty="false"
                                    @update:model-value="updateLedgerSelected" label="text" placeholder="Select one"
                                    track-by="text"></VueMultiselect>

                                <div class="invalid-meessage">{{ form.errors.ledger }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                        <button type="button" class="btn btn-info" @click="save">
                            <i class="bi bi-save2"></i>
                            <span class="mx-2">Save</span>
                        </button>
                    </div>
                    <LoaderBox v-if="busy"></LoaderBox>
                </div>
            </div>
        </div>

    </Layout>
</template>

<script setup lang="ts">
import Layout from '../../../components/Layout.vue';
const { auth, payheads } = defineProps<{
    auth: Auth,
    payheads: PayHead[]
}>();
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import { inject, onMounted, ref } from 'vue';
import VueMultiselect from 'vue-multiselect'
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import LoaderBox from '../../../components/LoaderBox.vue';
import { head } from 'lodash';
DataTable.use(DataTablesCore);
const bootstrap = inject<any>('bootstrap');


const options = {
    paging: false
}

const types = [
    {
        value: 'earning',
        text: 'Earning'
    },
    {
        value: 'dedcutions',
        text: 'Dedcutions'
    },
];

const ledgers = ref<Array<{ text: string, value: number }>>([])
const form = useForm<any>({
    name: '',
    type: '',
    ledger: null
})

const busy = ref(false);


const updateLedgerSelected = (ledger: { text: string, value: number } | null) => {
    form.ledger = ledger;


}

const selectType = (event: Event) => {

    const target = event.target as HTMLSelectElement;
    const val = target.value;

    form.ledger = null;
    ledgers.value = [];
    if (val) {
        if (val == 'earning') {
            loadLedgers(val)
        } else {
            loadLedgers(val)
        }
    } else {

    }
    form.type = val;
}

const loadLedgers = async (type: string) => {
    try {
        const url = route('admin.payhead.ledgers', { type });
        const { data } = await window.axios.get(url);
        ledgers.value = data;

    } catch (error) {
        console.error(error);
    }
}


const showModel = () => {
    const bs = new bootstrap.Modal('#payheadModal');
    bs.show(document.body)
}
const hideModel = () => {

    const modal = bootstrap.Modal.getOrCreateInstance('#payheadModal');
    modal.hide();
}

const save = async () => {



    busy.value = true;
    try {




        const url = route('admin.payhead.store');


        const ledger = form.ledger ? form.ledger.value : null;
        const name = form.name;
        const type = form.type;

        const { data } = await window.axios.post(url, { ledger, name, type });

        payheads.push(data);


        hideModel();

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

onMounted(() => {

})

</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>