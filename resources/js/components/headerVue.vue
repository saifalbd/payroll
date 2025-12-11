<template>
  <header>
    <div class=" bg-dark" :class="{ collapse }" id="navbarHeader">
      <div class="container">
        <div class="row pt-2">
          <div class=" col-sm-4 col-md-4">
            <div>
              <!-- <img v-if="emp.avatar" style="height: 200px;" class="img-thumbnail rounded" :src="emp.avatar.url" alt=""> -->
            </div>
          </div>
          <div class="col-sm-6 col-md-6 py-4">
            <h4 class="text-white"><i class="bi bi-person-badge"></i> <span class="mx-2">{{ auth.name }}</span></h4>
            <h5 class="text-white card-title"><i class="bi bi-postage"></i><span class="mx-2">{{ auth.designation }}</span></h5>
            <h5 class="text-white"> <i class="bi bi-pc-display-horizontal"></i> <span class="mx-2">{{ auth.department }}</span></h5>
            <h5 class="text-white"><i class="bi bi-envelope-at"></i> <span class="mx-2">{{ auth.email }}</span></h5>
            <h5 class="text-white"><i class="bi bi-phone"></i> <span class="mx-2">{{ auth.phone }}</span></h5>



          </div>
          <div class="col-sm-2 py-4">
       
            <Link :href="route('home')" method="post" class="btn btn-outline-warning" as="button"><i class="bi bi-lock"></i> <span class="mx-2">Logout</span></Link>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar shadow-sm">
      <div class="container">
        <a href="#" class="navbar-brand d-flex align-items-center">

          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-badge-tm"
            viewBox="0 0 16 16">
            <path
              d="M5.295 11V5.995H7V5H2.403v.994h1.701V11zm3.397 0V7.01h.058l1.428 3.239h.773l1.42-3.24h.057V11H13.5V5.001h-1.2l-1.71 3.894h-.039l-1.71-3.894H7.634V11h1.06z" />
            <path
              d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z" />
          </svg>
          <strong class="mx-4">{{ auth.companyName }}</strong>
        </a>
        <button class="navbar-toggler" type="button" @click="collapse = !collapse" data-bs-toggle="collapse"
          data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3'
const { auth } = defineProps<{
  auth: Auth
}>()

const collapse = ref(false)

</script>
