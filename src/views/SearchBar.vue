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
  gap: 8px;
  align-items: center;
}

input {
  padding: 8px;
  flex-grow: 1;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 8px 16px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>
