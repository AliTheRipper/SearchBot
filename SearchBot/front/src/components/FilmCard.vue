<template>
  <div class="film-card">
    <img :src="getPosterUrl(film.poster)" :alt="film.titre" />
    <h2>{{ film.titre }}</h2>
    <div class="actions">
      <button @click="ajouterFavori">⭐ Favori</button>
      <button @click="ajouterHistorique">👁️ Vu</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'FilmCard',
  props: {
    film: Object
  },
  methods: {
    getPosterUrl(posterPath) {
      return `https://image.tmdb.org/t/p/w500/${posterPath}`
    },
    async ajouterFavori() {
      try {
        const token = localStorage.getItem('token')
        await axios.post('http://localhost:8000/api/favoris', {
          film_id: this.film.id
        }, {
          headers: { Authorization: `Bearer ${token}` }
        })
        alert('Ajouté aux favoris !')
      } catch (err) {
        console.error(err)
        alert('Erreur ajout favoris')
      }
    },
    async ajouterHistorique() {
      try {
        const token = localStorage.getItem('token')
        await axios.post('http://localhost:8000/api/historiques', {
          film_id: this.film.id
        }, {
          headers: { Authorization: `Bearer ${token}` }
        })
        alert('Ajouté à l’historique !')
      } catch (err) {
        console.error(err)
        alert('Erreur ajout historique')
      }
    }
  }
}
</script>

<style scoped>
.film-card {
  text-align: center;
}
img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 12px;
}
.actions {
  margin-top: 8px;
  display: flex;
  justify-content: center;
  gap: 10px;
}
</style>

