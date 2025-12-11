<template>



    <main>

        <HeaderVue :emp="emp"></HeaderVue>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">{{emp.company.title}} Employee Panel</h1>
                    <p class="lead text-muted">Something short and leading about the collection below—its contents, the
                        creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it
                        entirely.</p>
                    <p>
                        <a :href="route('emp.leaveForm')" class="btn btn-primary btn-lg my-2">
                            <i class="bi bi-input-cursor"></i>
                            <span class="mx-2">Leave Request</span>
                        </a>
                     
                    </p>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row row-cols-1 g-3">
                    <div class="col" v-for="item in leaveApplications">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span>{{ item.type }}</span>
                                    <small class="text-body-secondary">{{ toNow(item.updated_at) }}</small>
                                </div>

                                
                                <span class="badge text-bg-danger" v-if="item.status==1">
                                   Approved
                                </span>
                                <span class="badge text-bg-success" v-else-if="item.status == 2">Rejected</span>
                                <span class="badge text-bg-light" v-else>Pending</span>
                            

                            </div>
                            <div class="card-body">

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
        </div>

    </main>

    <FooterVue></FooterVue>
</template>

<script setup lang="ts">
import moment from 'moment';
import FooterVue from '../../components/footerVue.vue';
import HeaderVue from '../../components/headerVue.vue';
interface Application {
    id: number
    emp_id: number
    dates: string[]
    type: string
    subject: string
    message: string
    created_at: string
    updated_at: string
    status: number
}

const { leaveApplications,emp } = defineProps<{
    leaveApplications: Application[],
     emp:Employee
}>()

const toNow = (d: string) => moment(d).toNow();
const dateIs = (d: string) => moment(d).format('Do MMMM YYYY')


</script>

<style scoped></style>