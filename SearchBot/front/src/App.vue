<template>
  <div class="app-container">
    <!-- Hamburger button (visible only when sidebar is hidden) -->
    <button
      v-if="!sidebarVisible"
      class="hamburger-open"
      @click="toggleSidebar"
    >
      <span class="line"></span>
      <span class="line"></span>
      <span class="line"></span>
    </button>

    <!-- Sidebar with slide transition -->
    <transition name="slide" :duration="{ enter: 300, leave: 300 }">
      <SideBar v-if="sidebarVisible" @closeSidebar="toggleSidebar" />
    </transition>

    <!-- Content wrapper with flex to push footer to bottom -->
    <div class="content-wrapper">
      <div class="main-content">
        <!-- Passe l'état de la sidebar au composant via v-slot -->
        <router-view v-slot="{ Component }">
          <component :is="Component" :isSidebarOpen="sidebarVisible" />
        </router-view>
      </div>
      <footer class="footer">
        Pied de page
      </footer>
    </div>
  </div>
</template>

<script setup>
import SideBar from './views/SideBar.vue'
import { isAuthenticated } from './auth'
import { ref } from 'vue';

// État de la sidebar
const sidebarVisible = ref(false)

// Méthode de bascule
const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value
}

</script>

<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
</style>

<style scoped>
/* The overall container uses flex in column direction and fills the viewport */
.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #1a1a1a;
  color: #fff;
  overflow-x: hidden;
  position: relative;
}

/* The content-wrapper takes all available space, ensuring the footer is pushed down */
.content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* The main content grows to fill the available space */
.main-content {
  flex: 1;
  padding: 20px;
}



/* Hamburger button styles */
.hamburger-open {
  position: absolute;
  top: 20px;
  left: 20px;
  background: none;
  border: none;
  display: flex;
  flex-direction: column;
  gap: 4px;
  cursor: pointer;
  z-index: 110;
}

.hamburger-open .line {
  width: 25px;
  height: 3px;
  background-color: #fff;
}

/* Slide transition for sidebar */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}
.slide-enter-to,
.slide-leave-from {
  transform: translateX(0);
}

.footer {
  grid-column: 1 / -1;
  padding: 10px 20px;
  background-color: #205372;
  text-align: center;
	}
</style>
