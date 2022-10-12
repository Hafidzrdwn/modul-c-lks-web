<template>
  <div>
    <div v-if="$route.name != 'login' && $route.name != 'register'">
        <Navbar />
    </div>
    <div class="container-fluid px-0">
      <router-view />
    </div>
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'

export default {
  data() {
    return {
      route: this.$route.name,
    }
  },
  name: 'App',
  components: {
    Navbar
  },
}
</script>

<style>

</style>