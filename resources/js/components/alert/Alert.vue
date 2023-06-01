<template>
    <v-snackbar
        :color="color"
        :timeout="timer"
        v-model="showSnackbar"
        top
        right
    >
      <v-icon left>{{icon}}</v-icon>{{message}}
      <template v-slot:action="{ attrs }">
        <v-btn
          text
          v-bind="attrs"
          @click="showSnackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </template>

  <script>
  export default {
    name: "vtoast",
    data() {
      return{
        showSnackbar: false,
        message: '',
        color: '',
        icon: '',
        timer: 3000
      }
    },
    methods:{
      show(data) {
        this.message = data.message || 'missing "message".'
        this.color = data.color || 'success'
        this.timer = data.timer || 3000
        this.icon = data.icon || 'mdi-check'
        this.showSnackbar = true
      }
    }
  }
  </script>
