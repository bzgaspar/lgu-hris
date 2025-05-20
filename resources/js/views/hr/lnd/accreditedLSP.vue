<template>
  <v-container>
    <v-card class="p-4">
      <v-form @submit.prevent="submitForm">
        <v-text-field v-model="form.provider_name" label="Provider Name" outlined dense required></v-text-field>
        <v-text-field v-model="form.location" label="Location" outlined dense required></v-text-field>
        <v-textarea v-model="form.services" label="Services" outlined dense required></v-textarea>
        <v-btn type="submit" >{{ form.id ? 'Update' : 'Add' }}</v-btn>
      </v-form>
    </v-card>

    <v-data-table :headers="headers" :items="providers" class="mt-4">
      <template v-slot:item.actions="{ item }">
        <v-btn icon @click="editItem(item)"><v-icon>mdi-pencil</v-icon></v-btn>
        <v-btn icon @click="deleteItem(item.id)" color="red"><v-icon>mdi-delete</v-icon></v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      providers: [],
      headers: [
        { text: 'Provider Name', value: 'provider_name' },
        { text: 'Location', value: 'location' },
        { text: 'Services', value: 'services' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      form: {
        id: null,
        provider_name: '',
        location: '',
        services: ''
      }
    };
  },
  mounted() {
    this.fetchProviders();
  },
  methods: {
    async fetchProviders() {
      const res = await axios.get('/api/providers/getAccreditedLearningServiceProvider');
      this.providers = res.data;
    },
    async submitForm() {
      if (this.form.id) {
        await axios.put(`/api/providers/${this.form.id}`, this.form);
      } else {
        await axios.post('/api/providers', this.form);
      }
      this.resetForm();
      this.fetchProviders();
    },
    editItem(item) {
      this.form = { ...item };
    },
    async deleteItem(id) {
      await axios.delete(`/api/providers/${id}`);
      this.fetchProviders();
    },
    resetForm() {
      this.form = { id: null, provider_name: '', location: '', services: '' };
    }
  }
};
</script>
