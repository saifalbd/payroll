<template>
    <div>
        <header-vue :auth="auth"></header-vue>
        <slot></slot>
        <footer-vue></footer-vue>
    </div>
</template>

<script setup lang="ts">
    import HeaderVue from './headerVue.vue';
    import FooterVue from './footerVue.vue';
    
    const {auth} = defineProps<{
        auth:Auth
    }>();

</script>

<style scoped>

</style>