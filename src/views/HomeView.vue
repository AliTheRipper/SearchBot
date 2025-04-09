<template>
  <div class="home-container">
    <h1 class="title">Que voulez-vous voir ?</h1>
    <div class="div-search-bar">
      <SearchBar 
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
      />
    </div>
    <div v-if="displayResults" class="resultgrid"> <!-- basculement de l'affichage -->
      <div v-if="!loading"> <!-- cache les éléments si les résultats sont en train de charger -->
        <div v-if="data == []">
          <!-- message aucun résultat -->
        </div>
        <!-- (note : je ne suis pas sûre que v-else apprécie être au même endroit que v-for, à tester)  -->
        <div v-else v-for="item in data"> <!-- affiche les éléments -->
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

const displayResults = ref(false) // fait passer de l'affichage recherche à l'affichage gallerie ; initialisé à false et ne repasse jamais en false
const data = ref([]) // la liste des objets réceptionnés depuis le backend
const loading = ref(false) //à faire passer en true quand on attend la réponse du backend

// Methods
const handleSearch = function(query) {
  displayResults = true
  loading = true

	console.log('User searched for:', query)

  const formData = new FormData
  formData.append(query)

  // Placeholder pour plus tard
  axios.post('/recherche', formData)
  .then((response) => {
    console.log(response.data)
    
    data = response.data
    loading = false
  })
  .catch((e) => {
    console.log(e)

    data = []
    loading = false
  })
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
</style>
