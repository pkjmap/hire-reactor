<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

/**
 * Component props
 * - clientId: ID of the selected client
 *   Used to fetch and store websites for that client
 */
const props = defineProps({
  clientId: {
    type: Number,
    required: true
  }
})

/**
 * Reactive state variables
 */
const websites = ref([])
const url = ref('')
const loading = ref(false)
const error = ref('')
const success = ref('')

/**
 * Fetch all websites for the selected client
 */
const loadWebsites = async () => {
  const res = await axios.get(`/api/clients/${props.clientId}/websites`)
  websites.value = res.data
}

/**
 * Watch for clientId changes
 * - Reload websites when a different client is selected
 */
watch(() => props.clientId, (id) => {
  if (id) loadWebsites()
})

/**
 * Submit a new website for the selected client
 */
const submit = async () => {
  error.value = ''
  success.value = ''
  loading.value = true

  try {
    await axios.post(`/api/clients/${props.clientId}/websites`, {
      url: url.value
    })

    success.value = 'Website added'
    url.value = ''
    loadWebsites()
  } catch (e) {
    error.value =
      e.response?.data?.message ||
      e.response?.data?.errors?.url?.[0] ||
      'Something went wrong'
  } finally {
    loading.value = false
  }
};
loadWebsites();

const confirmVisit = (url) => {
  if (confirm(`You are about to visit ${url}. Do you want to continue?`)) {
    window.open(url, '_blank')
  }
}
</script>

<template>
  <div>
    <h3>Add Website</h3>

    <!-- Max website limit warning -->
    <p v-if="websites.length >= 10" style="color:red">
      Maximum of 10 websites reached
    </p>

    <!-- Website submission form -->
    <form @submit.prevent="submit" v-if="websites.length < 10">
      <input
        type="url"
        v-model="url"
        placeholder="https://example.com"
        required
      />
      <button type="submit" :disabled="loading">
        {{ loading ? 'Saving...' : 'Add Website' }}
      </button>
    </form>

    <ul>
      <li v-for="site in websites" :key="site.id">
        <a href="#" @click.prevent="confirmVisit(site.url)">
          {{ site.url }}
        </a>
      </li>
    </ul>
  </div>
</template>
