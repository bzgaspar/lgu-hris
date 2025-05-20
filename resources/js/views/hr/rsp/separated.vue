<template>
  <v-container>
    <v-card class="mt-5 p-4">
      <v-card-title class="text-h6">Separation Form</v-card-title>
      <v-form class="mx-5">
        <v-row dense>
          <v-col cols="12" md="6">
            <v-combobox
              v-model="form.user_id"
              :items="userItems"
              label="Employee"
              item-text="name"
              item-value="id"
              dense
              outlined
            ></v-combobox>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="form.position"
              label="Position"
              dense
              outlined
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-combobox
              v-model="form.department_id"
              :items="departmentItems"
              label="Department"
              item-text="name"
              item-value="id"
              dense
              outlined
            ></v-combobox>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="form.date_separated"
              label="Date Separated"
              type="date"
              dense
              outlined
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="form.remarks"
              :items="['resign', 'retired']"
              label="Remarks"
              dense
              outlined
            ></v-select>
          </v-col>
          <v-col cols="12" class="text-right">
            <v-btn @click="submitForm">{{ form.id ? 'Update' : 'Add' }}</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>

        <v-data-table :headers="headers" :items="separations" :loading="loading" item-value="id">
  <template v-slot:item.user.name="{ item }">
    {{ item.user.first_name }} {{ item.user.last_name }}
  </template>
          <template v-slot:item.actions="{ item }">
            <v-btn color="blue" small @click="editForm(item)">Edit</v-btn>
            <v-btn color="red" small @click="deleteRecord(item.id)">Delete</v-btn>
          </template>
        </v-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      separations: [],
      userItems: [],
      departmentItems: [],
      headers: [
        { text: "User", value: "user.name" },
        { text: "Position", value: "position" },
        { text: "Department", value: "department.name" },
        { text: "Date Separated", value: "date_separated" },
        { text: "Remarks", value: "remarks" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      form: {
        id: null,
        user_id: null,
        position: "",
        department_id: null,
        date_separated: "",
        remarks: "resign",
      },
      dialog: false,
      loading: false,
    };
  },
  mounted() {
    this.fetchAll();
  },
  created() {
    this.fetchUsers();
    this.fetchDepartments();
  },
  methods: {
    async fetchAll() {
      this.loading = true;
      const res = await axios.get("/api/separations/getSeparated");
      this.separations = res.data;
      this.loading = false;
    },
    async fetchUsers() {
      const res = await axios.get("/api/getAllUser");
      this.userItems = res.data;
    },
    async fetchDepartments() {
      const res = await axios.get("/api/getDepartment");
      this.departmentItems = res.data;
    },
    submitForm() {
      const payload = {
        ...this.form,
        user_id: typeof this.form.user_id === 'object' ? this.form.user_id.id : this.form.user_id,
        department_id: typeof this.form.department_id === 'object' ? this.form.department_id.id : this.form.department_id,
      };

      const url = this.form.id ? `/api/separations/${this.form.id}` : "/api/separations";
      const method = this.form.id ? axios.put : axios.post;

      method(url, payload)
        .then(() => {
          this.$root.vtoast?.show({
            message: `Separation ${this.form.id ? 'updated' : 'added'}!`,
            color: "success",
            icon: "mdi-check-circle",
          });
          this.resetForm();
          this.fetchAll();
        })
        .catch((error) => {
          this.$root.vtoast?.show({
            message: `Failed to ${this.form.id ? 'update' : 'add'} record!`,
            color: "error",
            icon: "mdi-alert-circle",
          });
          console.error(error);
        });
    },
    editForm(item) {
      this.form = {
        id: item.id,
        user_id: item.user,
        position: item.position,
        department_id: item.department,
        date_separated: item.date_separated,
        remarks: item.remarks,
      };
      this.dialog = true;
    },
    deleteRecord(id) {
      if (!confirm("Are you sure you want to delete this record?")) return;
      axios.delete(`/api/separations/${id}`)
        .then(() => {
          this.$root.vtoast?.show({
            message: "Record deleted!",
            color: "success",
            icon: "mdi-check-circle",
          });
          this.fetchAll();
        })
        .catch((error) => {
          this.$root.vtoast?.show({
            message: "Failed to delete record!",
            color: "error",
            icon: "mdi-alert-circle",
          });
          console.error(error);
        });
    },
    resetForm() {
      this.form = {
        id: null,
        user_id: null,
        position: "",
        department_id: null,
        date_separated: "",
        remarks: "resign",
      };
      this.dialog = false;
    },
  },
};
</script>
