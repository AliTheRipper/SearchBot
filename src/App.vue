<template>
  <div id="app" class="app-container">
    <Sidebar />

    <!-- Main Content -->
    <div class="main-content">
      <!-- The router-view displays different pages if you use vue-router -->
      <router-view />
      <!-- If you’re not using router, you can just place your HomeView (or other content) directly here -->
    </div>

    <footer class="footer">
      Pied de page
    </footer>
  </div>
</template>

<script>
import Sidebar from './views/SideBar.vue'

export default {
  name: 'App',
  components: {
    Sidebar
  }
}
</script>

<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
</style>

<style scoped>
.app-container {
  display: grid;
  grid-template-columns: 200px 1fr; /* Sidebar fixed width, main area takes remaining space */
  grid-template-rows: 1fr auto;    /* Main area grows, footer is at the bottom */
  min-height: 100vh;
  background-color: #262626;       /* Dark background */
  color: #fff;                     /* White text */
}

.footer {
  grid-column: 1 / 3;
  padding: 25px 20px;
  background-color: #205372;
  text-align: center;
}
</style>
