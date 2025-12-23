<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Employees</h5>
            <Link type="button" class="btn btn-sm btn-primary" :href="route('admin.employee.create')">
                <i class="bi bi-bookmark-plus"></i>
                <span class="mx-2">Create</span>
            </Link>
        </div>
        <main class="container-fluid">
            <DataTable :options="options" class="table table-striped table-hover nowrap">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Joining DT</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Linkedin</th>
                        <th>NID</th>
                        <th>Current Address</th>
                        <th>Permanent Address</th>
                        <th>District</th>
                        <th>Police Station</th>
                        <th>Post Office</th>
                        <th>Village</th>
                        <th>Father</th>
                        <th>mother</th>

                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in employees">
                        <td class="text-center">
                            <img v-if="item.avatarUrl" class="img-thumbnail" style="height: 50px;" :src="item.avatarUrl" alt="">
                        </td>
                        <td class="text-center">{{ item.employee_id }}</td>
                        <td class="text-center">
                            <button class="btn btn-link" @click="showModel(item)">{{ item.employee_name }}</button>
                        </td>
                        <td class="text-center">{{ item.designation }}</td>
                        <td class="text-center">{{ item.department_id }}</td>
                        <td class="text-center">{{ item.joining_date }}</td>
                        <td class="text-center">{{ item.contact_no }}</td>
                        <td class="text-center">{{ item.email }}</td>
                        <td class="text-center">{{ item.linkedin }}</td>
                        <td class="text-center">{{ item.nid }}</td>
                        <td class="text-center">{{ item.current_address }}</td>
                        <td class="text-center">{{ item.permanent_address }}</td>
                        <td class="text-center">{{ item.district }}</td>
                        <td class="text-center">{{ item.police_station }}</td>
                        <td class="text-center">{{ item.post_office }}</td>
                        <td class="text-center">{{ item.village }}</td>
                        <td class="text-center">{{ item.father }}</td>
                        <td class="text-center">{{ item.mother }}</td>
                        <td class="text-center">

                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" @click="showModel(item)">
                                            <i class="bi bi-binoculars"></i>
                                            <span class="mx-2">Show</span>
                                        </a></li>
                                    <li><a class="dropdown-item" :href="route('admin.employee.edit',{employee:item.id})">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="mx-2">Edit</span>
                                        </a></li>

                                    <li><button class="dropdown-item" @click="remove(item)">
                                            <i class="bi bi-trash"></i>
                                            <span class="mx-2">Delete</span>
                                    </button></li>

                                </ul>
                            </div>


                        </td>
                    </tr>
                </tbody>


            </DataTable>
        </main>
        <!-- Modal -->
        <div class="modal modal-xl fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h1 class="modal-title fs-5" id="employeeModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">
                        <div class="row" v-if="emp">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0">
                                    <div class="card-header bg-primary text-white text-center p-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img :src="emp.avatarUrl"
                                                    class="rounded-circle border-3 border-white mb-3"
                                                    alt="Employee Photo"
                                                    style="width: 120px; height: 120px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-8 d-flex flex-column align-items-center justify-content-center">
                                                <h2 class=" capitalize">{{ emp.employee_name }}</h2>
                                                <p class="lead mb-0">{{ emp.designation }}</p>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="card-body p-4">

                                        <h4 class="card-title mb-3 text-primary">About {{ emp.employee_name }}</h4>
                                        <p class="card-text">Alex is responsible for defining the product strategy and
                                            roadmap for our flagship SaaS platform. With 10 years in the industry, he
                                            excels at cross-functional leadership and market analysis.</p>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="card-title mb-3 text-primary">Personal Informations</h4>
                                                <ul class="list-group list-group-flush mb-4">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-envelope-fill me-2 text-muted"></i>
                                                            Email</span>
                                                        <span class="text-secondary">{{ emp.email }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-calendar me-2 text-muted"></i>Joining
                                                            Date</span>
                                                        <span class="text-secondary">{{ emp.joining_date }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-pc-display me-2 text-muted"></i>Department</span>
                                                        <span class="text-secondary">{{ emp.department.name }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-telephone-fill me-2 text-muted"></i>NID</span>
                                                        <span class="text-secondary">{{ emp.nid }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-person-bounding-box me-2 text-muted"></i>Father</span>
                                                        <span class="text-secondary">{{ emp.father }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-person-bounding-box me-2 text-muted"></i>Mother</span>
                                                        <span class="text-secondary">{{ emp.mother }}</span>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="card-title mb-3 text-primary">Contact & Details</h4>
                                                <ul class="list-group list-group-flush mb-4">

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-telephone-fill me-2 text-muted"></i>Phone</span>
                                                        <span class="text-secondary">{{ emp.contact_no }}</span>
                                                    </li>


                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-linkedin me-2 text-muted"></i>Linkedin</span>
                                                        <span class="text-secondary">{{ emp.linkedin }}</span>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-pin-map me-2 text-muted"></i>Current
                                                            Address</span>
                                                        <span class="text-secondary">{{ emp.current_address }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-pin-map me-2 text-muted"></i>Permanent
                                                            Address</span>
                                                        <span class="text-secondary">{{ emp.permanent_address }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="bi bi-playstation me-2 text-muted"></i>District</span>
                                                        <span class="text-secondary">{{ emp.district }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-playstation me-2 text-muted"></i>Police
                                                            Station</span>
                                                        <span class="text-secondary">{{ emp.police_station }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-building me-2 text-muted"></i>Post
                                                            Office</span>
                                                        <span class="text-secondary">{{ emp.post_office }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><i class="bi bi-house me-2 text-muted"></i>Village</span>
                                                        <span class="text-secondary">{{ emp.village }}</span>
                                                    </li>


                                                </ul>
                                            </div>

                                        </div>


                                        <!-- <h4 class="card-title mb-3 text-primary">Key Skills</h4>
                                        <p>
                                            <span class="badge bg-success me-2">Jira</span>
                                            <span class="badge bg-success me-2">Agile/Scrum</span>
                                            <span class="badge bg-success me-2">Market Research</span>
                                            <span class="badge bg-success me-2">User Stories</span>
                                            <span class="badge bg-success me-2">Roadmapping</span>
                                        </p> -->
                                    </div>
                                    <div class="card-footer text-center">
                                        <small class="text-muted">Joined the team on June 2015</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>

<script setup lang="ts">
import Layout from '../../../components/Layout.vue';
const { auth, employees } = defineProps<{
    auth: Auth,
    employees: Employee[]
}>();
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { inject, onMounted, reactive, ref } from 'vue';
import { deleteConfirm, deleteError } from '../../../utility';
const bootstrap = inject<any>('bootstrap');
DataTable.use(DataTablesCore);


const options = {
    paging: false
}

const emp = ref<Employee | null>(null);

const showModel = (item: Employee) => {
    emp.value = item;
    const bs = new bootstrap.Modal('#employeeModal');
    bs.show(document.body)
}

const remove = async (item:Employee)=>{
    const is = await  deleteConfirm(``);

    if(!is) return; 
    try {
        const url = route('admin.employee.destroy',{employee:item.id});
       await window.axios.delete(url);
    } catch (error) {
        console.error(error);
        deleteError(error)
    }
}
onMounted(() => {

})
</script>

<style lang="scss" scoped>
@import 'datatables.net-bs5';
</style>