<template>
  <aside class="sidebar">
    <!-- Logo cliquable pour revenir à l'accueil -->
    <div class="logo">
      <router-link to="/" class="logo-link">
        <img src="@/assets/logo.png" alt="Logo" /><!-- image-->
      </router-link>
    </div>
    <nav class="nav">
      <router-link to="/" class="nav-item">Recherche</router-link>
      <router-link to="/historique" class="nav-item">Historique</router-link>
      <router-link to="/tendances" class="nav-item">Tendances</router-link>
      <router-link to="/favoris" class="nav-item">Favoris</router-link>
      <router-link to="/logout" class="nav-item">Déconnexion</router-link>
    </nav>
  </aside>
</template>

<script>
export default {
  name: 'SideBar'
}
</script>

<style scoped>
.sidebar {
  background-color: #383838;
  height: 100vh;
  display: flex;
  flex-direction: column;
  padding: 20px;
}

.logo {
  margin-bottom: 2rem;
}

.logo-link {
  text-decoration: none;
  color: inherit;
  display: flex;
  align-items: center;
}

.logo-link img {
  max-width: 150px; /* Ajustez la taille de votre logo */
  width: 100%;
  height: auto;
}

.nav {
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
  background-color: #404040;
}
</style>
