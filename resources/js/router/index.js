import { createRouter, createWebHistory } from 'vue-router'
import VueRouteMiddleware from 'vue-route-middleware'

import Index from '../views/Index.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
// import Admin from '../views/Admin.vue'
import User from '../views/User.vue'

import guest from '../middleware/guest'
import auth from '../middleware/auth'
import checkRole from '../middleware/checkRole'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Index,
    meta: {
      title: 'Home'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      title: 'Login',
      middleware: [auth]
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      title: 'Register',
      middleware: [auth]
    }
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import(/* webpackChunkName: "admin" */ '../views/Admin.vue'),
    meta: {
      title: 'Admin',
      middleware: [guest, checkRole]
    }
  },
  {
    path: '/user',
    name: 'user',
    component: User,
    meta: {
      title: 'User',
      middleware: [guest]
    }
  },
]

const router = createRouter({
  history: createWebHistory('/'),
  routes
})

router.beforeEach(VueRouteMiddleware({ guest, auth, checkRole }));
router.afterEach((to, from) => {
  document.title = `${import.meta.env.VITE_APP_TITLE} ${to.meta.title}`
})

export default router