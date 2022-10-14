<template>
  <body class="login">
  
    <div class="row g-0">
      <div class="col-md-4">
        <div class="head">
          <router-link class="h1 text-decoration-none text-white" :to="{name:'home'}">Geek Bot</router-link>
          <h2 class="text-white mt-2">
            Log In
          </h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-style text-center text-white">
            <h1 class="mb-3">Log In</h1>
            <img src="../../assets/images/Login.png">
            <p class="text-danger">{{ message }}</p>
            <form>
              <div class="mb-3">
                <p>Email</p>
                <input type="email" v-model="formData.email">
              </div>
              <div class="mb-3">
                <p>Password</p>
                <input type="password" autocomplete="off" v-model="formData.password">
              </div>
              <button type="submit" @click.prevent="handleLogin">Log In</button>
              <p class="small m-0 mt-3">Tidak punya akun? <router-link :to="{ name:'register' }">Register</router-link></p>
            </form>
        </div>
      </div>
    </div>
  </body>
</template>

<script>

export default {
  name: 'Login',
  data() {
    return {
      message: "",
      formData: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async handleLogin() {

      try {
        const res = await fetch(base('/login'), {
          method: 'POST',
          body: JSON.stringify(this.formData),
          ...fetchConf
        })
        const data = await res.json()
        if (data.status) {
          localStorage.setItem('token', data.token)
          localStorage.setItem("RlUsFcekR", data.user.role);
          localStorage.setItem("fakeCstm", JSON.stringify({ id: data.user.idCustomer , name: data.user.nama }));
          const routeName = (data.user.role) ? 'admin' : 'home'
          // redirect route
          this.$router.push({ name: routeName })
        } else {
          this.message = data.message
          this.formData = {
            email: '',
            password: ''
          }
        }
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>

<style scoped>
.form-style {
  top: 60%;
  left: 55%;
}
</style>