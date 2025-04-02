import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue' // adjust the path if necessary

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView
  },
  // Add more routes here if needed
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
