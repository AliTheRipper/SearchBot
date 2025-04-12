<template>
  <div class="home-container">
    <h1 class="title">Que voulez-vous voir ?</h1>
    
    <div class="div-search-bar" :class="{ 'reduced-width': isSidebarOpen }">
      <SearchBar 
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
      />
    </div>

    <div v-if="displayResults" class="resultgrid">
      <div v-if="!loading">
        <div v-if="data.length === 0">
          <p>Aucun résultat trouvé.</p>
        </div>
        <div v-else v-for="item in data" :key="item.id">
          <Result
            :id="item.id"
            :movie-title="item.movieTitle"
            :director="item.director"
            :year="item.year"
            :summary="item.summary"
            :poster="item.poster"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'
import Result from '@/views/Result.vue'
import { ref } from 'vue'
import axios from 'axios'

const displayResults = ref(false) // fait passer de l'affichage recherche à l'affichage gallerie ; initialisé à false et ne repasse jamais en false
const data = ref([]) // la liste des objets réceptionnés depuis le backend
const loading = ref(false) //à faire passer en true quand on attend la réponse du backend

const handleSearch = async (query) => {
  displayResults.value = true
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('query', query) // ✅ clé + valeur

    const response = await axios.post('http://127.0.0.1:8000/api/recherche', formData)
    data.value = response.data
  } catch (error) {
    data.value = []
  } finally {
    loading.value = false
  }
}


// Props
defineProps({
  isSidebarOpen: Boolean
})




</script>

<style scoped>
.title {
  font-size: 3rem;
  text-align: center;
  margin-top: 15rem;
  margin-bottom: 10rem;
  font-weight: lighter;
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
  transition: min-width 0.3s ease;
}

.reduced-width {
  min-width: 60%;
}
</style>
