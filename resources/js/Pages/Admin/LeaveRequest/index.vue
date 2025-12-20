<template>
    <Layout :auth="auth">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Leave Applications</a>
    <a type="button" class="btn btn-dark" :href="route('leaveApp.create')">
        <i class="bi bi-bookmark-plus"></i>
        <span class="mx-2">Create</span>
    </a>
  </div>
</nav>
        <main class="container-fluid">
            <div class="container mt-4">

                <div class="row row-cols-1 g-3">
                    <div class="col" v-for="item in leaveApplications">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span>{{ item.type }}</span>
                                    <small class="text-body-secondary">{{ toNow(item.updated_at) }}</small>
                                </div>


                                <span class="badge text-bg-danger" v-if="item.status == 1">
                                    Approved
                                </span>
                                <span class="badge text-bg-success" v-else-if="item.status == 2">Rejected</span>
                                <span class="badge text-bg-light" v-else>Pending</span>


                            </div>
                            <div class="card-body p-2" v-if="auth.has == 'employee'">

                                <div class=" row"></div>

                                <h5 class="card-title">{{ item.subject }}</h5>
                                <p class="card-text">{{ item.message }}</p>



                                <figure>
                                    <blockquote class="blockquote">
                                        <p>Dates Of</p>
                                    </blockquote>
                                    <figcaption class="blockquote-footer">
                                        {{item.dates.map(e => dateIs(e)).join(',')}}
                                    </figcaption>
                                </figure>

                            </div>
                            <div v-else>
                                <div class=" row">
                                    <div class=" col-4 d-flex justify-content-center">
                                        <img class="img-thumbnail my-2" style="width: 200px;" :src="item.employee.avatarUrl" alt="">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title">{{ item.subject }}</h5>
                                        <p class="card-text">{{ item.message }}</p>



                                        <figure>
                                            <blockquote class="blockquote">
                                                <p>Dates Of</p>
                                            </blockquote>
                                            <figcaption class="blockquote-footer">
                                                {{item.dates.map(e => dateIs(e)).join(',')}}
                                            </figcaption>
                                        </figure>
                                    </div>

                                    <div class=" col-4 text-center">
                                        
                                        <small class="d-block">Last Updated: {{ toNow(item.updated_at) }}</small>
                                    </div>
                                    <div class=" col-8 flex justify-content-end">
                                        <ul class="list-group list-group-horizontal">
                                            <li class="list-group-item d-flex items-center">
                                                <div class="circle-box primary" @click="changeStatus(item, 0)">
                                                    <i v-show="item.status == 0" class="bi bi-circle-fill"></i>
                                                </div>
                                                <span class="mx-2">Pending</span>
                                            </li>
                                            <li class="list-group-item d-flex items-center">
                                                 <div class="circle-box success" @click="changeStatus(item, 1)">
                                                    <i v-show="item.status == 1" class="bi bi-circle-fill"></i>
                                                </div>
                                                
                                                 <span class="mx-2">Approved</span>
                                                </li>
                                            <li class="list-group-item d-flex items-center">
                                                <div class="circle-box danger" @click="changeStatus(item, 2)">
                                                    <i v-show="item.status == 2" class="bi bi-circle-fill"></i>
                                                </div>
                                                 <span class="mx-2">Rejected</span>
                                                </li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer d-flex  justify-content-end align-items-center" v-if="!item.status">
                                <button type="button" class="btn btn-outline-danger btn-sm mx-1">
                                    <i class="bi bi-trash2"></i>
                                    <span class="mx-2">Delete</span>
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm mx-1">
                                    <i class="bi bi-pencil-fill"></i>
                                    <span class="mx-2">Edit</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </Layout>
</template>

<script setup lang="ts">

import moment from 'moment'
import Layout from '../../../components/Layout.vue';
import Swal from 'sweetalert2'
const { auth, leaveApplications } = defineProps<{
    auth: Auth,
    leaveApplications: Application[]
}>();
const toNow = (d: string) => moment(d).toNow();
const dateIs = (d: string) => moment(d).format('Do MMMM YYYY')
  const changeStatus = (item:Application, status:number)=> {

            if (item.status == status) return;

            Swal.fire({
                title: "Are you sure?",
                text: `Are you sure to update the leave application status for ${item.employee.employee_name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Update it!"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    item.status = status;
                    const url = route('admin.payRoll.employee.leaveRequest.update', { leave_application: item.id }, false);
                    await window.axios.put(url, { status })

                }
            })


        }


</script>



<style lang="scss" scoped>
    @import 'sweetalert2/src/sweetalert2.scss';
</style>