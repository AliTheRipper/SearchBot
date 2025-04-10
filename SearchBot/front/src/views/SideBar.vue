<template>
  <aside ref="sidebarRef" class="SideBar">
    <SideBar v-if="isSidebarOpen" @closeSidebar="isSidebarOpen = false" />

    <div class="sidebar-header">
      <!-- Logo: clickable to go home -->
      <router-link to="/logo" class="logo-link">
        <img src="@/assets/logo.png" alt="Logo" />
      </router-link>
      <!-- Bouton flèche pour fermer la sidebar -->
      <button class="close-button" @click="$emit('closeSidebar')">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="12 4 6 10 12 16" />
        </svg>
      </button>
    </div>
    <nav class="nav">
      <router-link to="/home" class="nav-item" @click="$emit('closeSidebar') ">Recherche</router-link>
      <router-link to="/historique" class="nav-item" @click="$emit('closeSidebar') ">Historique</router-link>
      <router-link to="/Register" class="nav-item" @click="$emit('closeSidebar') ">Register</router-link>
      <router-link to="/" class="nav-item" @click="$emit('closeSidebar') ">Login</router-link>
      <router-link to="/logout" class="nav-item" @click="$emit('closeSidebar')">Déconnexion</router-link>
    </nav>
  </aside>
</template>

<script setup>
import { onMounted, onUnmounted, ref, defineEmits } from 'vue'

const emit = defineEmits(['closeSidebar'])
const sidebarRef = ref(null)

const handleClickOutside = (event) => {
  // Vérifie que le clic ne s'est pas fait DANS la sidebar
  if (sidebarRef.value && !sidebarRef.value.contains(event.target)) {
    emit('closeSidebar')
  }
}

onMounted(() => {
  // Petit délai pour éviter les fermetures immédiates à l'ouverture
  setTimeout(() => {
    document.addEventListener('click', handleClickOutside)
  }, 0)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.SideBar {
  position: fixed; /* Fixed to prevent layout shifts */
  top: 0;
  left: 0;
  width: 200px;
  height: 100%;
  background-color: #262626;
  z-index: 100;
  padding: 20px;
  display: flex;
  flex-direction: column;
  grid-row: 1 / span 2; /* Span both rows (content and footer) */
}


.sidebar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-link {
  text-decoration: none;
  color: inherit;
}

.logo-link img {
  max-width: 100px;
  height: auto;
}

.close-button {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.nav {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.nav-item {
  text-decoration: none;
  color: #fff;
  font-size: 1rem;
  padding: 0.5rem 0.8rem;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.nav-item:hover {
  background-color: #4e4e4e;
}
</style>
