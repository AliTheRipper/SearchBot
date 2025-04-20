<template>
    <div class="result-container" @click="openModal">
        <img :src="poster" :alt="movieTitle">
        <div class="info">
            <h1>{{ movieTitle }}</h1>
            <h2>{{ genres }} • {{ year }}</h2>
            <p>{{ summary }}</p>
            <br>
            <p class="dim-text">Cliquez pour afficher la fiche technique</p>
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

const props = defineProps({
  id: {
    type: Number,
    default: 0
  },
  movieTitle: {
    type: String,
    default: 'N/A'
  },
  director: {
    type: String,
    default: 'N/A'
  },
  year: {
    type: Number,
    default: 0
  },
  poster: {
    type: String,
    default: 'https://www.themoviedb.org/assets/2/v4/glyphicons/basic/glyphicons-basic-38-picture-grey-c2ebdbb057f2a7614185931650f8cee23fa137b93812ccb132b9df511df1cfac.svg'
  },
  summary: {
    type: String,
    default: ''
  },
  genres: {
    type: Array,
    default: () => []
  },
  grade: {
    type: String,
    default: 'N/A'
  },
  length: {
    type: String,
    default: 'N/A'
  },
  ageRating: {
    type: String,
    default: 'N/A'
  },
  mainActors: {
    type: Array,
    default: () => []
  }
});

const showModal = ref(false);

const movieData = {
  id: props.id,
  movieTitle: props.movieTitle,
  director: props.director,
  year: props.year,
  poster: props.poster,
  summary: props.summary,
  genres: props.genres,
  grade: props.grade,
  length: props.length,
  ageRating: props.ageRating,
  mainActors: props.mainActors
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
    max-width: 200px;
    height: auto;
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

