<template>
  <nav class="navbar navbar-expand-lg py-0 navbar-dark sticky-top">
    <div class="container">
      <router-link :to="{ name: 'home' }" class="nav-head-custom"
        >GEEK BOT</router-link
      >
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav ms-auto" v-if="isLogin && $route.path != '/admin'">
          <li class="nav-item">
            <router-link :to="{name:(authUser.role) ? 'admin' : 'user'}" class="nav-link">{{ authUser.nama }}</router-link>
          </li>
          <li class="nav-item"><a href="#" class="nav-link" @click.prevent="handleLogout">Log Out</a></li>
        </ul>
        <ul class="nav navbar-nav ms-auto" v-else-if="isLogin && $route.path == '/admin'">
          <li class="nav-item"><a href="#" class="nav-link">Admin</a></li>
        </ul>
        <ul class="nav navbar-nav ms-auto" v-else>
          <li class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link"
              >Log in</router-link
            >
          </li>
          <li class="nav-item">
            <router-link :to="{name:'register'}" class="nav-link">Register</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { ref } from '@vue/reactivity';
export default {
  name: "Navbar",
  setup() {
    const isLogin = ref(false);
    const authUser = ref(null);

    const checkAuth = async () => {
      try {
        const response = await axios.get("/checkAuth");
        if (response.data.status) {
          isLogin.value = true;
          authUser.value = response.data.data;
        } else {
          isLogin.value = false;
          authUser.value = null;
        }
      } catch (err) {
        console.error(err);
      }
    };

    const handleLogout = async () => {
      if (confirm("Apakah anda yakin ingin Log Out?")) {
        try {
          await axios.get("/sanctum/csrf-cookie");
          const response = await axios.post("/logout");
          if (response.data.status) {
            localStorage.clear();
            location.reload();
          }
        } catch (err) {
          console.error(err);
        }
      }
    }

    checkAuth();

    return {
      isLogin,
      authUser,
      handleLogout
    };

  },
};
</script>