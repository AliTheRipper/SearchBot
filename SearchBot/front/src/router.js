import { createRouter, createWebHistory } from 'vue-router'
import Register from './views/register.vue'  
import HomeView from './views/HomeView.vue'
import Login from './views/login.vue'
import Favoris from './views/Favoris.vue'
import Historique from './views/Historique.vue'
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
  },
  {
    path: '/favoris',
    name: 'Favoris',
    component: Favoris
  },
  {
    path: '/historique',
    name: 'Historique',
    component: Historique
  }
  
 
]

const router = createRouter({
  history: createWebHistory(),
  routes
})



export default router





