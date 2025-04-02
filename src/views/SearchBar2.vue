<template>
    <div class="search-bar">
      <input
        type="text"
        :placeholder="placeholder"
        v-model="searchQuery"
        @keyup.enter="onSearch"
      />
      <!-- The icon can be an <img>, an inline SVG, or an icon from a library -->
      <button class="search-icon" @click="onSearch">
 
        <!-- Option 2: If you prefer an <img> icon: -->
        <img src="@/assets/search.png" alt="search icon" />
        
      </button>
    </div>
  </template>
  
  <script>
  export default {
    name: 'SearchBar',
    props: {
      placeholder: {
        type: String,
        default: 'Search...'
      }
    },
    data() {
      return {
        searchQuery: ''
      }
    },
    methods: {
      onSearch() {
        this.$emit('search', this.searchQuery)
      }
    }
  }
  </script>
  
  <style scoped>
  .search-bar {
    display: flex;
    align-items: center;
    border: 1px solid #000; /* Black border */
    border-radius: 9999px;  /* Fully rounded corners */
    padding: 0.5rem 1rem;
    background-color: #fff; /* White background */
    width: 300px;           /* Adjust as needed */
  }
  
  /* The text input */
  .search-bar input {
    flex-grow: 1;             /* Takes remaining space */
    border: none;             /* Remove default border */
    outline: none;            /* Remove focus outline */
    font-size: 1rem;
    background-color: transparent;
    /* Adjust text color if needed */
  }
  
  /* The button containing the icon */
  .search-icon {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    margin-left: 8px; /* Some spacing before icon */
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  /* If you want to change the icon color */
  .search-icon svg {
    color: #000; /* Black icon */
  }
  </style>
  