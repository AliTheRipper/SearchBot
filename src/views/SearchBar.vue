<template>
  <div class="search-bar">
    <input
      type="text"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @keyup.enter="onSearch"
      :disabled="disabled"
    />
    <button @click="onSearch" :disabled="disabled">
      <img src="../assets/search_white.png" class="loupe"/>
    </button>
  </div>
</template>

<script setup>

const emit = defineEmits(["search", "update:modelValue"]);

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Tapez votre recherche...'
  },
  disabled: {
    type: Boolean,
    default: false
  },
  modelValue: {
    type: String,
    default: ''
  }
});

const onSearch = () => {
  if (!props.disabled) {
    emit('search', props.modelValue);
  }
};
</script>

<style scoped>
.search-bar {
  display: flex;
  align-items: center;
}

input {
  padding: 8px;
  padding-left: 16px;
  flex-grow: 1;
  border: none;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  height: 3rem;
  background: #383838;
  color: #ffffff;
  font-size: large;
}

input:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

button {
  padding: 8px 16px;
  background: "../assets/search.png";
  background-color: #383838;
  color: #ffffff;
  border: none;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
  border-left: 2px solid #262626;
  cursor: pointer;
  height: 4rem;
}

button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

button:hover {
  background-color: #4e4e4e;
}

.loupe {
  float:left;
  margin-right:0.5em;
  height: 1.5rem;
}
</style>
