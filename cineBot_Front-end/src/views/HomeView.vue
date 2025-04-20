<template>
  <div class="home-container">
    <!-- La barre de recherche s'affiche en haut sur l'écran des résultats -->
    <div class="sticky-search" v-if="displayResults">
      <SearchBar 
      v-model="currentQuery"
        ref="searchBar"
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
        :disabled="loading"
      />
    </div>
    
    <!-- La barre de recherche s'affiche initialement au milieu -->
    <div v-if="!displayResults" class="centered-search">
      <h1 class="title">Que voulez-vous voir ?</h1>
      <div class="div-search-bar">
        <SearchBar 
          v-model="currentQuery"
          placeholder="Je veux voir un film romantique dont le role principal est joué par une actrice."
          @search="handleSearch"
          :disabled="loading"
        />
      </div>
    </div>
    
    <!-- Résultats -->
    <div v-if="displayResults">
      <div v-if="!loading">
        <div v-if="data.length === 0" class="no-results">
          <h1 class="title dim-text">Aucun résultat trouvé.</h1>
        </div>
        <div v-else >
          <h1 class="result-title">Résultats</h1>
          <div class="result-grid">
            <Result
              v-for="item in data"
              :key="item.id"
              :id="item.id"
              :movie-title="item.movieTitle"
              :director="item.director"
              :year="item.year"
              :summary="item.summary"
              :poster="item.poster"
              :genres="item.genres"
              :grade="item.grade"
              :length="item.length"
              :ageRating="item.ageRating"
              :main-actors="item.mainActors"
            />
          </div>
        </div>
      </div>
      <div v-else class="loading">
        <h1 class="title dim-text">Chargement des résultats...</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'
import Result from '@/views/Result.vue'
import { ref } from 'vue'
import axios from 'axios'

const displayResults = ref(false)
const data = ref([])
const loading = ref(false)
const currentQuery = ref("")

function getCookieValue(name) {
  const value = `; ${document.cookie}`
  const parts = value.split(`; ${name}=`)
  if (parts.length === 2) return parts.pop().split(';').shift()
}

const handleSearch = async (query) => {
  currentQuery.value = query
  displayResults.value = true
  loading.value = true

  axios.defaults.withCredentials = true
  axios.defaults.baseURL = 'http://localhost:8000'

  try {
    await axios.options('/sanctum/csrf-cookie')
    const csrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'))

    const response = await axios.post('/send-message', {
      message: query
    }, {
      headers: {
        'X-XSRF-TOKEN': csrfToken
      }
    })

    console.log("Réponse du serveur :", response.data)

    // Map le JSON du backend en objets adaptés à <Result />
    data.value = response.data.movies.slice(0, 6).map(movie => ({
      id: movie.id,
      movieTitle: movie.title,
      director: "N/A", 
      year: movie.release_date ? new Date(movie.release_date).getFullYear() : "N/A",
      summary: movie.overview,
      poster: movie.poster_path,
      genres: movie.genres || [], 
      grade: movie.vote_average ? `${movie.vote_average}/10` : "N/A",
      length: "N/A",
      ageRating: "N/A",
      mainActors: movie.actors || []
    }))

  } catch (error) {
    console.error("Erreur:", error.response?.data || error)
    data.value = [] // Tu peux garder les films fictifs si tu préfères
  } finally {
    loading.value = false
  }
}
</script>



<style scoped>
.title {
  font-size: 3rem;
  text-align: center;
  margin-top: 15rem;
  margin-bottom: 10rem;
  font-weight: lighter;
}

.result-title {
  font-size: 3rem;
  text-align: center;
  font-weight: lighter;
}

.dim-text {
  color: #5e5e5e
}

.home-container {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.div-search-bar {
  margin-bottom: auto;
  margin-right: auto;
  margin-left: auto;
  min-width: 80%;
}

.result-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 40px;
  padding: 20px;
  width: 100%;
  max-width: auto;
  margin: 0 auto;
  box-sizing: border-box;
}

@media (max-width: 1500px) {
  .result-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 1000px) {
  .result-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

.result-grid > * {
  width: 100%;
}

.sticky-search {
  position: sticky;
  top: 0;
  padding: 2rem;
  z-index: 1;
}

.centered-search {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}
</style>