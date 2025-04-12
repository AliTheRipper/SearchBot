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

defineProps(['id','movieTitle', 'director', 'year', 'poster', 'summary'])

const openModal = function(id) {
    // Ouvrir le popup
}
</script>

<style scoped>
.result-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    max-width: 30%;
    max-height: 300px;
    background: #383838;
    border-radius: 20px;
    overflow: hidden;
}

.result-container img {
    max-height: 300px;
}

.info {
    display: flex;
    flex-direction: column;
    padding: 10px;
    width: 100%;
}

.info p {
    display: -webkit-box;
    -webkit-line-clamp: 10;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0;
}

.info h1 {
    margin: 0;
}

.info h2 {
    margin: 0;
}
</style>