<script setup>
import { route } from 'ziggy-js';
import MainLayout from "../Layout/MainLayout.vue";
  defineProps({
        second: String
    })
</script>
<template>
    <MainLayout>
    <div>
        <h1>Это вторая страница</h1>
        <div>{{ second }}</div>
    </div>
        <a :href="route('index')">Назад на главную</a>
  </MainLayout>
</template>

<style scoped>
</style>
