<template>
  <div class="home-container">
    <h1 class="title">Que voulez-vous voir ?</h1>
    <SearchBar 
      placeholder="Je veux voir un film d'horreur de plus de deux heures."
      @search="handleSearch"
    />
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
  margin-bottom: 1rem;
  text-align: center;
}
</style>
