<template>
  <div class="home-container">
    <h1 class="title">Que voulez-vous voir ?</h1>
    <div class="div-search-bar">
      <SearchBar 
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
      />
    </div>
    <div v-if="displayResults" class="resultgrid">
      <Result/>
      <Result/>
      <Result/>
      <Result/>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'
import Result from '@/views/Result.vue'
import { ref } from 'vue'

const displayResults = ref(false)

// Methods
const handleSearch = function(query) {
	console.log('User searched for:', query)

  const formData = new FormData
  formData.append(query)

  // Placeholder pour plus tard
  axios.post('/recherche', formData)
  .then((response) => {
    console.log(response.data)
  })
  .catch((e) => {
    console.log(e)
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
