<template>
    <div class="result-container" @click="openModal">
        <img :src="poster" :alt="movieTitle">
        <div class="info">
            <h1>{{ movieTitle }}</h1>
            <h2>{{ director }} • {{ year }}</h2>
            <p>{{ summary }}</p>
            <br>
            <p class="dim-text">(Cliquez pour afficher la fiche technique)</p>
        </div>
    </div>
    
    <MovieModal 
      v-if="showModal"
      :movie="movieData"
      @close="closeModal"
    />
</template>

<script setup>
import { ref } from 'vue';
import MovieModal from './MovieModal.vue';

const props = defineProps(['id', 'movieTitle', 'director', 'year', 'poster', 'summary']);
const showModal = ref(false);

const movieData = {
  id: props.id,
  movieTitle: props.movieTitle,
  director: props.director,
  year: props.year,
  poster: props.poster,
  summary: props.summary
};

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};
</script>

<style scoped>
.result-container {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 10px;
    max-height: 300px;
    background: #383838;
    border-radius: 20px;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
    cursor: pointer;
}

.result-container:hover {
    background: #4e4e4e;
}

.result-container img {
    max-height: 300px;
    width: auto;
}

.info {
    display: flex;
    flex-direction: column;
    padding: 10px;
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.info h1 {
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.info h2 {
    color: #a0a0a0;
    font-weight: normal;
    margin-top: 0.5rem;
}

.info p {
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 8px;
    word-break: break-word;
}

.home-container {
  position: relative;
  z-index: 1;
}

.dim-text {
  color: #a0a0a0
}
</style>

