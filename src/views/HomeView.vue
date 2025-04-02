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

<script>
import SearchBar from '@/views/SearchBar.vue'
//import SearchBar2 from '@/views/SearchBar2.vue'

export default {
  name: 'HomeView',
  components: {
    SearchBar
  },
  methods: {
    handleSearch(query) {
      console.log('User searched for:', query)
      // Implémentez votre logique de recherche ici
    }
  }
}
</script>

<style scoped>
.title {
  font-size: 2rem;
  text-align: center;
  margin-top: 15rem;
  margin-bottom: 10rem;
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
