import { createRouter, createWebHistory } from 'vue-router'
import Register from './views/register.vue'  
import HomeView from './views/HomeView.vue'
import Login from './views/login.vue'


const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/home',
    name: 'Home',
    component: HomeView
  }
  
 
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
