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

<style>
.result-container {
    display: flex;
    flex-direction: column;
}

.info {
    display: flex;
    flex-direction: row;
}
</style>