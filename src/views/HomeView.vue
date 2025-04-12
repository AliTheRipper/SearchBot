<template>
  <div class="home-container">
    <div v-if="!displayResults">
      <h1 class="title">Que voulez-vous voir ?</h1>
      <div class="div-search-bar">
        <SearchBar 
          placeholder="Je veux voir un film d'horreur de plus de deux heures."
          @search="handleSearch"
        />
      </div>
    </div>
    
    <div v-if="displayResults">
      <div v-if="!loading">
        <!-- Pas de résultat -->
        <div v-if="data.length === 0" class="no-results">
          <h1 class="title">Aucun résultat trouvé.</h1>
        </div>

        <!-- Affichage des résultats -->
        <div v-else class="result-grid">
          <Result
            v-for="item in data"
            :key="item.id"
            :id="item.id"
            :movie-title="item.movieTitle"
            :director="item.director"
            :year="item.year"
            :summary="item.summary"
            :poster="item.poster"
          />
        </div>
      </div>
      <div v-else class="loading">
        <h1 class="title">Chargement...</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'
import Result from '@/views/Result.vue'
import { ref } from 'vue'

const displayResults = ref(false) // Start with search UI
const data = ref([])
const loading = ref(false)

const handleSearch = async (query) => {
  displayResults.value = true
  loading.value = true

  try {
    const response = await axios.post('/recherche', { query })
    data.value = response.data.slice(0, 6) // Limit to 5 results
  } catch (e) {
    console.error(e)
    data.value = []
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
  gap: 20px;
  padding: 20px;
  width: 100%;
  max-width: auto;
  margin: 0 auto;
  box-sizing: border-box;
}

@media (max-width: 1200px) {
  .result-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 900px) {
  .result-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

.result-grid > * {
  width: 100%;
}
</style>
