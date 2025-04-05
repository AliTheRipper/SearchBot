<template>
    <div class="result-container" @click="openPopup">
        <img :src="poster">
        <h1>{{ titreFilm }}</h1>
        <h2>{{ director }} - {{ year }}</h2>
        <p>{{ summary }}</p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps(['id','movieTitle', 'director', 'year', 'poster', 'summary'])

const openPopup = function(id) {
    // Ouvrir le popup
}
</script>

<style>

</style>