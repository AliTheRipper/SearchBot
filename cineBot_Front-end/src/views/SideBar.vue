<template>
  <aside class="SideBar">
    <div class="sidebar-header">
      <!-- Logo: clickable to go home -->
      <router-link to="/" class="logo-link">
        <img src="@/assets/logo-removebg-preview.png" alt="Logo" />
      </router-link>
      <!-- Bouton flèche pour fermer la sidebar -->
      <button class="close-button" @click="$emit('closeSidebar')">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="12 4 6 10 12 16" />
        </svg>
      </button>
    </div>
    <nav class="nav">
      <router-link to="/" class="nav-item">Recherche</router-link>
      <router-link to="/historique" class="nav-item">Historique</router-link>
      <router-link to="/tendances" class="nav-item">Tendances</router-link>
      <router-link to="/favoris" class="nav-item">Favoris</router-link>
      <router-link to="/logout" class="nav-item">Se Connecter</router-link>
    </nav>
  </aside>
</template>

<script setup>
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
