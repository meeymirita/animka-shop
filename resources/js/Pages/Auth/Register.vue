<script setup>
import { ref } from "vue";
import axios from "axios";

let login = ref("");
let email = ref("");
let password = ref("");

function registerUserFromFormData() {
  const data = new FormData();
  data.append('login', login.value);
  data.append('email', email.value);
  data.append('password', password.value);

  axios.post('/register', data)
    .then(res => {
      if (res.data.success) {
        alert(res.data.message);
        window.location.href = res.data.redirect;
      }
    })
    .catch(err => {
      if (err.response?.status === 422) {
        console.error(err.response.data.errors);
      } else {
        console.error(err.response?.data || err);
      }
    });
}

</script>

<template>
  <div class="container">
    <div class="mb-3">
      <label for="login" class="form-label">login</label>
      <input v-model="login" type="text" class="form-control" id="login" placeholder="login">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input v-model="email" type="email" class="form-control" id="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">password</label>
      <input v-model="password" type="password" class="form-control" id="password" placeholder="password">
    </div>
    <button @click="registerUserFromFormData" type="button" class="btn btn-dark">Регистрация</button>
  </div>
</template>
