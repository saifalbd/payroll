<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center mt-4">
            <h5 class="ms-1 page-title" role="button" @click="sub_menu=!sub_menu">Attendance</h5>
        </div>
        <div v-if="sub_menu" class="d-flex gap-3 align-items-center mb-3 ps-2">
            <div class="fw-bold" :class="selected_page === 'details' ? 'page-title' : 'text-secondary'" role="button" @click="selected_page='details'">Attendance Daily</div>
            <div class="fw-bold" :class="selected_page === 'sheet' ? 'page-title' : 'text-secondary'" role="button" @click="selected_page='sheet'">Attendance Sheet Monthly</div>
        </div>
        <div v-if="selected_page == 'details'">
            <attendanceDetails></attendanceDetails> 
        </div>
        <div v-if="selected_page == 'sheet'">
            <attendanceSheet></attendanceSheet>
        </div>
    </Layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Layout from '../../../components/Layout.vue';
import attendanceSheet from './attendanceSheet.vue';
import attendanceDetails from './attendanceDetails.vue';
const { auth } = defineProps<{
    auth: Auth
}>();
const sub_menu = ref(false);
const selected_page = ref('details');
</script>