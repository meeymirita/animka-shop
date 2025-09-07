<script setup>
import { ref } from "vue";
import axios from "axios";

let email = ref("");
let password = ref("");

function loginUserFromFormData() {
  const data = new FormData();
  data.append('email', email.value);
  data.append('password', password.value);

  axios.post('/login', data, )
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
        <label for="email" class="form-label">Email address</label>
        <input v-model="email" type="email" class="form-control" id="email" placeholder="name@example.com">
     </div>
     <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input v-model="password" type="password" class="form-control" id="password" placeholder="password">
    </div>
    <button @click="loginUserFromFormData" type="button" class="btn btn-dark">Логин</button>
  </div>
</template>


<style scoped>

</style>
