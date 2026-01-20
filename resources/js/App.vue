<script setup>
import { ref } from 'vue'
import AddClient from './components/AddClient.vue'
import ClientWebsiteViewer from './components/ClientWebsiteViewer.vue'

// Reactive key to trigger refresh
const refreshKey = ref(0)

// Called when AddClient emits event
const onClientAdded = () => {
  refreshKey.value++
}
</script>

<template>
  <div>
    <h1>Uptime Monitor</h1>

    <!-- Listen for client-added event -->
    <AddClient @client-added="onClientAdded" />

    <hr />

    <!-- Pass refresh trigger -->
    <ClientWebsiteViewer :refresh-key="refreshKey" />
  </div>
</template>
