<template>
  <div class="login-container">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <p class="error" v-if="validationErrors.email">{{ validationErrors.email[0] }}</p>

      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <p class="error" v-if="validationErrors.password">{{ validationErrors.password[0] }}</p>

      <button type="submit">Se connecter</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    <router-link to="/register">Pas encore inscrit ?</router-link>
  </div>
</template>


<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { isAuthenticated } from '../auth'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const validationErrors = ref({})

const router = useRouter()

const login = async () => {
  try {
  const response = await axios.post('http://127.0.0.1:8000/api/login', {
    email: email.value,
    password: password.value
  })

  if (response.data.success) {
    isAuthenticated.value = true
    router.push('/home')
  } else {
    errorMessage.value = response.data.message || "Identifiants incorrects"
  }
} catch (error) {
  if (error.response?.status === 422) {
    // Erreurs de validation Laravel (ex: champ vide ou email invalide)
    validationErrors.value = error.response.data.errors
  } else {
    errorMessage.value = error.response?.data?.message || "Erreur lors de la connexion"
  }

  console.error(error.response?.data || error)
}
}
</script>

<style scoped>
.login-container {
max-width: 400px;
margin: 50px auto;
background-color: #222;
padding: 20px;
border-radius: 10px;
color: white;
}
input, button {
display: block;
width: 100%;
margin-bottom: 10px;
padding: 8px;
}
button {
background-color: #205372;
color: white;
border: none;
cursor: pointer;
}
.error {
color: red;
}
</style>