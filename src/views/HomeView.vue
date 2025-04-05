<template>
  <div class="home-container">
    <h1 class="title">Que voulez-vous voir ?</h1>
    <div class="div-search-bar">
      <SearchBar 
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
      />
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'

// Methods
const handleSearch = function(query) {
	console.log('User searched for:', query)
	// Implémentez votre logique de recherche ici
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
