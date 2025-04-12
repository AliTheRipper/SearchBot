<template>
  <div class="home-container">
    <!-- La barre de recherche s'affiche en haut sur l'écran des résultats -->
    <div class="sticky-search" v-if="displayResults">
      <SearchBar 
      v-model="currentQuery"
        ref="searchBar"
        placeholder="Je veux voir un film d'horreur de plus de deux heures."
        @search="handleSearch"
        :disabled="loading"
      />
    </div>
    
    <!-- La barre de recherche s'affiche initialement au milieu -->
    <div v-if="!displayResults" class="centered-search">
      <h1 class="title">Que voulez-vous voir ?</h1>
      <div class="div-search-bar">
        <SearchBar 
          v-model="currentQuery"
          placeholder="Je veux voir un film d'horreur de plus de deux heures."
          @search="handleSearch"
          :disabled="loading"
        />
      </div>
    </div>
    
    <!-- Résultats -->
    <div v-if="displayResults">
      <div v-if="!loading">
        <div v-if="data.length === 0" class="no-results">
          <h1 class="title dim-text">Aucun résultat trouvé.</h1>
        </div>
        <div v-else >
          <h1 class="result-title">Résultats</h1>
          <div class="result-grid">
            <Result
              v-for="item in data"
              :key="item.id"
              :id="item.id"
              :movie-title="item.movieTitle"
              :director="item.director"
              :year="item.year"
              :summary="item.summary"
              :poster="item.poster"
            />
          </div>
        </div>
      </div>
      <div v-else class="loading">
        <h1 class="title dim-text">Chargement des résultats...</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/views/SearchBar.vue'
import Result from '@/views/Result.vue'
import { ref } from 'vue'

const displayResults = ref(false)
const data = ref([])
const loading = ref(false)
const currentQuery = ref("")

const handleSearch = async (query) => {
  currentQuery.value = query
  displayResults.value = true
  loading.value = true

  try {
    const response = await axios.post('/recherche', { query })
    data.value = response.data.slice(0, 6) // Seuls les 6 premiers résultats sont récupérés ; à modifier/retirer au besoin
  } catch (e) {
    console.error(e)
    data.value = [
    {
        "id": 1,
        "movieTitle": "La La Land",
        "director": "Damien Chazelle",
        "year": 2016,
        "summary": "Au cœur de Los Angeles, une actrice en devenir prénommée Mia sert des cafés entre deux auditions. De son côté, Sebastian, passionné de jazz, joue du piano dans des clubs miteux pour assurer sa subsistance. Tous deux sont bien loin de la vie rêvée à laquelle ils aspirent… Le destin va réunir ces doux rêveurs, mais leur coup de foudre résistera-t-il aux tentations, aux déceptions, et à la vie trépidante d’Hollywood ?",
        "poster": "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/5KIj6aioW1UtUT1IV0qqW5iZbNH.jpg"
      },
      {
        "id": 1,
        "movieTitle": "La Favorite",
        "director": "Yorgos Lanthimos",
        "year": 2018,
        "summary": "Début du XVIIIème siècle. L’Angleterre et la France sont en guerre. Toutefois, à la cour, la mode est aux courses de canards et à la dégustation d’ananas. La reine Anne, à la santé fragile et au caractère instable, occupe le trône tandis que son amie Lady Sarah gouverne le pays à sa place. Lorsqu’une nouvelle servante, Abigail Hill, arrive à la cour, Lady Sarah la prend sous son aile, pensant qu’elle pourrait être une alliée. Abigail va y voir l’opportunité de renouer avec ses racines aristocratiques. Alors que les enjeux politiques de la guerre absorbent Sarah, Abigail quant à elle parvient à gagner la confiance de la reine et devient sa nouvelle confidente. Cette amitié naissante donne à la jeune femme l’occasion de satisfaire ses ambitions, et elle ne laissera ni homme, ni femme, ni politique, ni même un lapin se mettre en travers de son chemin.",
        "poster": "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/bZC5VeHX39PfhsZEcdjD7RHKFSH.jpg"
      },
      {
        "id": 1,
        "movieTitle": "Monthy Python : La Vie de Brian",
        "director": "Terry Jones",
        "year": 1979,
        "summary": "En l’an 0, en terre de Galilée, Mandy et son bébé Brian reçoivent la visite des Rois Mages un beau soir de décembre. Ceux‐ci, s’apercevant de leur erreur, remballent prestement leurs présents et filent dans l’étable voisine. Hélas, Brian a tiré le mauvais numéro…",
        "poster": "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/6RKbtDCMUaPboo1WYBUCNoVxgA9.jpg"
      },
      {
        "id": 1,
        "movieTitle": "Le Parrain",
        "director": "Francis Ford Coppola",
        "year": 1972,
        "summary": "La Seconde Guerre mondiale vient de s'achever. À New York, le « parrain » Don Corleone, l'un des chefs respectés de la mafia, se sent vieillir. Il refuse de s'adapter à son temps et de se lancer, comme ses pairs, dans le trafic de drogue. Une frilosité qui entrave la bonne marche des affaires des autres « familles » et qui lui vaut d'être la cible d'un attentat. Don Corleone survit à ses blessures, mais reste très diminué. Mike, son plus jeune fils, qui jusque-là se tenait à l'écart des affaires de son père, devient le plus dévoué de ses héritiers. Plus efficace que ses frères, Sonny et Fredo, il venge son père et organise l'élimination de ses adversaires…",
        "poster": "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/k3uIbYtiuK8pwbCcbma29nTqmgG.jpg"
      }
    ]
  } finally {
    loading.value = false
  }
}

</script>

<style scoped>
.title {
  font-size: 3rem;
  text-align: center;
  margin-top: 15rem;
  margin-bottom: 10rem;
  font-weight: lighter;
}

.result-title {
  font-size: 3rem;
  text-align: center;
  margin: 0;
  font-weight: lighter;
}

.dim-text {
  color: #5e5e5e
}

.home-container {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.div-search-bar {
  margin-bottom: auto;
  margin-right: auto;
  margin-left: auto;
  min-width: 80%;
}

.result-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 20px;
  padding: 20px;
  width: 100%;
  max-width: auto;
  margin: 0 auto;
  box-sizing: border-box;
}

@media (max-width: 1500px) {
  .result-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 1000px) {
  .result-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

.result-grid > * {
  width: 100%;
}

.sticky-search {
  position: sticky;
  top: 0;
  padding: 2rem;
  z-index: 1;
}

.centered-search {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}
</style>
