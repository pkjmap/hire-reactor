<script setup>
import { ref } from 'vue'
import axios from 'axios'

// Declare emitted events
const emit = defineEmits(['client-added'])

const email = ref('')
const loading = ref(false)
const success = ref('')
const error = ref('')

const submit = async () => {
  error.value = ''
  success.value = ''
  loading.value = true

  try {
    const response = await axios.post('/api/clients', {
      email: email.value
    })

    success.value = response.data.message
    email.value = ''

    // 🔔 Notify parent that a client was added
    emit('client-added')

  } catch (e) {
    if (e.response?.data?.errors?.email) {
      error.value = e.response.data.errors.email[0]
    } else {
      error.value = 'Something went wrong'
    }
  } finally {
    loading.value = false
  }
}
</script>


<template>
  <div style="max-width: 400px">
    <h2>Add Client Email</h2>
    <!-- Email submission form -->
    <form @submit.prevent="submit">
      <input
        type="email"
        v-model="email"
        placeholder="client@example.com"
        required
      />
      <!-- Submit button -->
      <button type="submit" :disabled="loading">
        {{ loading ? 'Saving...' : 'Add Client' }}
      </button>
    </form>

    <p v-if="success" style="color: green">{{ success }}</p>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>
