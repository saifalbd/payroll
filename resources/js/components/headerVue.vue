<template>
  <nav class="navbar navbar-expand-lg bg-dark-light">
    <div class="container-fluid mx-4">
      <Link class="navbar-brand" :href="auth.has == 'admin' ? route('admin.home') : route('employee.home')">{{
        auth.companyName }}</Link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <Link class="nav-link" aria-current="page"
              :href="auth.has == 'admin' ? route('admin.home') : route('employee.home')">Home</Link>
          </li>

          <li class="nav-item" v-if="auth.has == 'admin'">

            <Link class="nav-link" aria-current="page" :href="route('admin.employee.index')"
              :class="{ 'active':active(['admin.employee.index']) }">Employees</Link>
          </li>
          <li class="nav-item" v-if="auth.has == 'admin'">

            <Link class="nav-link" aria-current="page" :href="route('admin.department.index')"
              :class="{ 'active': active(['admin.department.index'])}">Departments</Link>
          </li>

          <li class="nav-item" v-if="auth.has == 'admin'">
            <Link class="nav-link" aria-current="page" :href="route('admin.payhead.index')"
                :class="{ 'active': active(['admin.payhead.index']) }">Payheads</Link>
          </li>

          <li class="nav-item" v-if="auth.has == 'admin'">
            <Link class="nav-link" aria-current="page"
             :class="{ 'active': active(['admin.salaryScale.index']) }"
              :href="route('admin.salaryScale.index')" >Salary Scales</Link>
          </li>

          <li class="nav-item" v-if="auth.has == 'admin'">
            <Link class="nav-link" aria-current="page"
            :class="{ 'active': active(['admin.salarySetup.index']) }"
            :href="route('admin.salarySetup.index')">Salary Setup</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" aria-current="page"
                  :class="{ 'active': active(['leaveApp.index','admin.leaveApp']) }"
              :href="auth.has == 'admin' ? route('admin.leaveApp') : route('leaveApp.index')">Leave Applications</Link>

          </li>

        </ul>
        <form class="d-flex" role="search">

          <Link v-if="auth.has == 'employee'" :href="route('employeeLogout')" method="post" as="button"
            class="btn btn-warning">
            <i class="bi bi-person-lock"></i>
            <span class="mx-1">Logout</span>
          </Link>
          <Link v-else-if="auth.has == 'admin'" :href="route('adminLogout')" method="post" as="button"
            class="btn btn-warning">
            <i class="bi bi-person-lock"></i>
            <span class="mx-1">Logout</span>
          </Link>
        </form>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { inject, onMounted, ref } from 'vue';

import { Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js';
import { act } from 'react';
const { auth } = defineProps<{
  auth: Auth
}>()
const bootstrap = inject('bootstrap');
const collapse = ref(false);
const page = usePage();

const active = (urls:string[])=>{
  const list = urls.map(e=>route(e,{},false));
  return list.findIndex(p=>page.url.startsWith(p)) >-1;
}

onMounted(() => {
  try {
    // Expanding the navbar.
    const collapse = new bootstrap.Collapse('#navbarSupportedContent');
    collapse.show();
  } catch (e) {
    console.log('Bootstrap error: ', e);
  }
});
</script>
<style scoped>
.navbar{
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  border-top: 3px solid #f08080;
  background: rgba(255, 217, 102, .8);
  transition: .5s ease;
  z-index: 3;
  padding: .4rem 1rem .3rem;
}
.navbar .nav-item .nav-link{
  font-weight: 500;
  font-size: 16px;
  padding: 0.8rem 1rem;
}
</style>
