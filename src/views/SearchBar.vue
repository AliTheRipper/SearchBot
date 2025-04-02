<template>
  <div class="search-bar">
    <input
      type="text"
      :placeholder="placeholder"
      v-model="searchQuery"
      @keyup.enter="onSearch"
    />
    <button @click="onSearch">Rechercher</button>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    placeholder: {
      type: String,
      default: 'Tapez votre recherche...'
    }
  },
  data() {
    return {
      searchQuery: ''
    }
  },
  methods: {
    onSearch() {
      // Émet l'événement "search" avec le contenu du champ de recherche
      this.$emit('search', this.searchQuery)
    }
  }
}
</script>

<style scoped>
.search-bar {
  display: flex;
  align-items: center;
}

input {
  padding: 8px;
  padding-left: 16px;
  flex-grow: 1;
  border: none;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  height: 2rem;
  background: #383838;
  color: #ffffff;
  font-size: large;
}

button {
  padding: 8px 16px;
  background-color: #383838;
  color: #ffffff;
  border: none;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  cursor: pointer;
  height: 3rem;
}

button:hover {
  background-color: #4e4e4e;
}
</style>
