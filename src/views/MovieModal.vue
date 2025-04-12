<template>
  <div class="modal-overlay" @click.self="closeModal">
    <div class="modal-container">
      <button class="close-button" @click="closeModal">×</button>
      <div class="modal-content">
        <div class="modal-poster">
          <img :src="movie.poster" :alt="movie.movieTitle">
        </div>
        <div class="modal-details">
          <h1>{{ movie.movieTitle }}</h1>
          <h2>{{ movie.director }} • {{ movie.year }}</h2>
          <div class="modal-summary">
            <p>{{ movie.summary }}</p>
          </div>
          <div class="modal-technical">
            <h3>Fiche technique</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  movie: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['close']);

const closeModal = () => {
  emit('close');
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-container {
  background-color: #383838;
  border-radius: 20px;
  width: 80%;
  max-width: 900px;
  max-height: 80vh;
  overflow-y: auto;
  position: relative;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

.close-button {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  color: white;
  font-size: 2rem;
  cursor: pointer;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.close-button:hover {
  background-color: #4e4e4e;
}

.modal-content {
  display: flex;
  gap: 2rem;
}

.modal-poster img {
  max-height: 400px;
  border-radius: 10px;
}

.modal-details {
  flex: 1;
}

.modal-details h1 {
  margin-top: 0;
  font-size: 2rem;
}

.modal-details h2 {
  color: #a0a0a0;
  font-weight: normal;
  margin-top: 0.5rem;
}

.modal-summary {
  margin: 1.5rem 0;
  line-height: 1.6;
}

.modal-technical {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #4e4e4e;
}

@media (max-width: 768px) {
  .modal-content {
    flex-direction: column;
  }
  
  .modal-poster img {
    max-height: 300px;
    margin: 0 auto;
  }
}
</style>