<template>
  <div class="login-container">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <p class="error" v-if="validationErrors.email">{{ validationErrors.email[0] }}</p>

      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <p class="error" v-if="validationErrors.password">{{ validationErrors.password[0] }}</p>
      
      
      <div v-if="loading" class="spinner"></div>
      <button type="submit" :disabled="loading">
        <span v-if="!loading">Login</span>
        <span v-else>Logging in...</span>
      </button>

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
const loading = ref(false)


const login = async () => {
  loading.value = true

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
    loading.value = false

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
finally {
    loading.value = false
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
.spinner {
  margin: 10px auto;
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid #fff;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>