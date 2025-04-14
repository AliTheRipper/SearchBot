
<template>
  <div class="favoris-page">
    <h1>Mes films favoris</h1>
    <div class="film-grid">
      <FilmCard
        v-for="favori in favoris"
        :key="favori.id"
        :film="favori.film"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import FilmCard from '../components/FilmCard.vue'

export default {
  name: 'Favoris',
  components: { FilmCard },
  data() {
    return {
      favoris: [],
    }
  },
  async mounted() {
    try {
      const token = localStorage.getItem('token')
      const response = await axios.get('http://localhost:8000/api/favoris', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      this.favoris = response.data
    } catch (error) {
      console.error('Erreur lors du chargement des favoris :', error)
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

