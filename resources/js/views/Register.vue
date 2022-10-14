<template>
  <body class="login">
  
    <div class="row g-0 justify-content-start">
      <div class="col-md-4">
        <div class="head">
          <router-link class="h1 text-decoration-none text-white" :to="{name:'home'}">Geek Bot</router-link>
          <h2 class="text-white mt-2">
            Register
          </h2>
          </div>
        </div>
      <div class="col-md-4">
        <div class="form-style text-white text-center">
            <h1>
              Register
            </h1>
            <img src="../../assets/images/Login.png">
            <p class="text-danger">{{ message }}</p>
            <form>

              <div class="mb-3">
                <p>Nama</p>
                <input type="text" v-model="formData.nama">
              </div>
              <div class="mb-3">
                <p>Email</p>
                <input type="email" v-model="formData.email">
              </div>
              <div class="mb-3">
                <p>Password</p>
                <input type="password" v-model="formData.password"> 
              </div>
              <div class="mb-3">
                <p>No HP</p>
                <input type="text" v-model="formData.noHP">
              </div>
              <div class="mb-3">
                <p>Alamat Rumah</p>
                <input type="text" v-model="formData.alamat">
              </div>

              <button type="submit" @click.prevent="handleSubmit">Register</button>
              <p class="small m-0 mt-3">Sudah punya akun? <router-link :to="{ name:'login' }">Log In</router-link>
              </p>
            </form>
        </div>
      </div>
    </div>
  </body>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Register',
  data() {
    return {
      message: "",
      formData: {
        nama: '',
        email: '',
        password: '',
        noHP: '',
        alamat: '',
      },
    }
  },
  methods: {
    async handleSubmit() {

      try {

        const res = await fetch(base('/register'), {
          method: 'POST',
          body: JSON.stringify(this.formData),
          ...fetchConf
        })
        const data = await res.json()

        if (data.status) {
          this.$router.push({ name: 'login' })
        } else {
          this.message = data.message
        }
        
      } catch (err) {
        console.error(err)
      }

    },
  }
}
</script>

<style scoped>
.form-style
  {
    top: 80%;
    left: 55%;
  }
</style>