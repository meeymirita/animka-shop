<script setup>
import { route } from 'ziggy-js';
import MainLayout from "./Layout/MainLayout.vue";
import {ref, onMounted} from "vue";
import axios from "axios";
const props = defineProps({
    data: Object
})

let user = ref(null);
let isAuth = ref(false);

onMounted(() => {
  axios.get('/me', )
  .then(res => {
    console.log(res.data);
  })
});
</script>

<template>
    <main-layout>
         <div>
            <h1>Привет</h1>
            <a :href="route('second')">Перейти на вторую страницу</a>
         </div>
        <div>
            <ul>
                <li v-for="item in props.data">
                  {{ item }}
                </li>
            </ul>
        </div>
        <div>
            <input class="form-control" type="text" name="" id="" @keydown="myInput">
        </div>

    </main-layout>
</template>


<style scoped>
</style>
