<template>
  <div class="register-container">
    <h1>Inscription</h1>
    <form @submit.prevent="register">
      <div>
        <div>
        <label for="name">Nom :</label>
        <input type="text" id="name" v-model="name" required />
        <p class="error" v-if="validationErrors.name">{{ validationErrors.name[0] }}</p>
      </div>


        <label for="email">Email :</label>
        <input type="email" id="email" v-model="email" required>
        <p class="error" v-if="validationErrors.email">{{ validationErrors.email[0] }}</p>
      </div>

      <div>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" v-model="password" required>
        <p class="error" v-if="validationErrors.password">{{ validationErrors.password[0] }}</p>
      </div>

      <div>
        <label for="confirmPassword">Confirmez le mot de passe :</label>
        <input type="password" id="confirmPassword" v-model="confirmPassword" required>
        <p class="error" v-if="password !== confirmPassword">Les mots de passe ne correspondent pas</p>
      </div>

      <button type="submit">S'inscrire</button>
      <p class="error" v-if="errorMessage">{{ errorMessage }}</p>
      <p class="success" v-if="successMessage">{{ successMessage }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const errorMessage = ref('')
const successMessage = ref('')
const validationErrors = ref({})
const router = useRouter()

const register = async () => {
  if (password.value !== confirmPassword.value) {
    errorMessage.value = "Les mots de passe ne correspondent pas"
    return
  }

  errorMessage.value = ''
  successMessage.value = ''
  validationErrors.value = {}

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', {
      name: name.value,
      email: email.value,
      password: password.value
    })

    if (response.data.success) {
      successMessage.value = "Inscription réussie !"
      router.push('/') // redirection après succès
    }
  } catch (error) {
    if (error.response?.status === 422) {
      validationErrors.value = error.response.data.errors
    } else {
      errorMessage.value = error.response?.data?.message || "Erreur lors de l'inscription"
    }
    console.error(error.response?.data)
  }
}
</script>

<style scoped>
.register-container {
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
.success {
  color: green;
}
</style>
