<template>
  <div class="historique-page">
    <h1>Mon historique de visionnage</h1>
    <div class="film-grid">
      <FilmCard
        v-for="element in historiques"
        :key="element.id"
        :film="element.film"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import FilmCard from '../components/FilmCard.vue'

export default {
  name: 'Historique',
  components: { FilmCard },
  data() {
    return {
      historiques: [],
    }
  },
  async mounted() {
    try {
      const token = localStorage.getItem('token')
      const userId = localStorage.getItem('user_id') // Assure-toi de bien le stocker au login

      const response = await axios.get(`http://localhost:8000/api/users/${userId}/historiques`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })

      this.historiques = response.data
    } catch (error) {
      console.error('Erreur lors du chargement de l’historique :', error)
    }
  }
}
</script>

<style scoped>
.film-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}
</style>

