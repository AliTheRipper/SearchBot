<template>
    <div class="result-container" @click="openModal">
        <img :src="poster">
        <div class="info">
            <h1>{{ movieTitle }}</h1>
            <h2>{{ director }} - {{ year }}</h2>
            <p>{{ summary }}</p>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps(['id', 'movieTitle', 'director', 'year', 'poster', 'summary']);

const openModal = function(id) {
    // Ouvrir le popup
    console.log("film " + id + " cliqué")
};
</script>

<style scoped>
.result-container {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 10px;
    max-height: 200px;
    background: #383838;
    border-radius: 20px;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
    cursor: pointer;
}

.result-container:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
    background: #4e4e4e;
}

.result-container img {
    max-height: 200px;
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

.info h1,
.info h2 {
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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
</style>

