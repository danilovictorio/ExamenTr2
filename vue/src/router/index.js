import { createRouter, createWebHistory } from 'vue-router'
import TheWelcome from '../components/TheWelcome.vue'
import LoginComponent from '../components/LoginComponent.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: TheWelcome
  },
  {
    path: '/login',
    name: 'login',
    component: LoginComponent
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
