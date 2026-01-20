<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import AddWebsite from './AddWebsite.vue'

const props = defineProps({
  refreshKey: {
    type: Number,
    required: true
  }
})

const clients = ref([])
const selectedClient = ref('')

/**
 * Load all clients
 */
const loadClients = async () => {
  const res = await axios.get('/api/clients')
  clients.value = res.data
}

/**
 * Initial load
 */
loadClients()

/**
 * Reload clients when a new client is added
 */
watch(
  () => props.refreshKey,
  () => {
    loadClients()
    selectedClient.value = ''
  }
)
</script>

<template>
  <div>
    <h3>Select Client</h3>

    <select v-model="selectedClient">
      <option disabled value="">Select client email</option>
      <option
        v-for="client in clients"
        :key="client.id"
        :value="client.id"
      >
        {{ client.email }}
      </option>
    </select>

    <AddWebsite
      v-if="selectedClient"
      :clientId="selectedClient"
    />
  </div>
</template>
