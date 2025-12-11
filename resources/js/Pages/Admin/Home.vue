<template>
    <div>
        <HeaderVue :auth="auth"></HeaderVue>
    </div>
</template>

<script setup lang="ts">
import HeaderVue from '../../components/headerVue.vue';

const {auth} = defineProps<{
    auth:Auth
}>()


</script>

