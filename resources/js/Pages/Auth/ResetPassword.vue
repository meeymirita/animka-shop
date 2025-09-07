<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

const page = usePage();
let email = ref(page.props.email || "");
let password = ref("");
let password_confirmation = ref("");
let token = ref(page.props.token || "");

function resetPassword() {
  axios.post('/reset-password', {
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    token: token.value,
  })
    .then(res => {
        alert(res.data.message);
        if (res.data.success) {
            window.location.href = '/login-form';
        }
    })
    .catch(err => console.error(err.response?.data || err));
}
</script>


<template>
    <div class="container">
        <input v-model="email" placeholder="Email" class="form-control mb-2"/>
        <input v-model="password" type="password" placeholder="Password" class="form-control mb-2"/>
        <input v-model="password_confirmation" type="password" placeholder="Confirm" class="form-control mb-2"/>
        <button @click="resetPassword" class="btn btn-dark">Сбросить пароль</button>
    </div>
</template>
