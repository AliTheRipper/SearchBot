<template>
  <div class="search-bar">
    <input
      type="text"
      :placeholder="placeholder"
      v-model="searchQuery"
      @keyup.enter="onSearch"
    />
    <button style="display:inline-block" @click="onSearch">
      <img src="../assets/search_white.png" class="loupe"/>
    </button>
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
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  height: 3rem;
  background: #383838;
  color: #ffffff;
  font-size: large;
}

button {
  padding: 8px 16px;
  background: "../assets/search.png";
  background-color: #383838;
  color: #ffffff;
  border: none;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
  border-left: 2px solid #262626;
  cursor: pointer;
  height: 4rem;
}

button:hover {
  background-color: #4e4e4e;
}

.loupe {
  float:left;
  margin-right:0.5em;
  height: 1.5rem;
}
</style>
