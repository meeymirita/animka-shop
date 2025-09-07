<script setup>
import { ref } from "vue";
import axios from "axios";

let email = ref("");

function forgotPasswordUserFromFormData() {
  const data = new FormData();
  data.append('email', email.value);

  axios.post('/forgot-password', data, )
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
    <button @click="forgotPasswordUserFromFormData" type="button" class="btn btn-dark">отправить</button>
  </div>
</template>


<style scoped>

</style>
