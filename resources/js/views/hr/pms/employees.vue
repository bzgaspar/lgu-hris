<template>
    <v-app style="min-height: 0px !important">
        <v-card>
            <v-card-title>
                <v-row justify-center>
                    <v-col xs="12" class="text-center">
                        <v-combobox
                            :items="genderItems"
                            v-model="genderFilterValue"
                            label="Gender"
                            solo
                            dense
                        ></v-combobox>
                    </v-col>
                    <v-col xs="12" class="text-center">
                        <v-combobox
                            :items="departmentItems"
                            v-model="departmentFilterValue"
                            label="Department"
                            solo
                            dense
                        ></v-combobox>
                    </v-col>
                    <v-col xs="12" class="text-center">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            solo
                            dense
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="users"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deletePMS(item.id)"
                    >
                        <i class="fa-solid fa-trash me-1"></i>Delete
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            search: "",
            genderFilterValue: "",
            departmentFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            departmentItems: [],
            selected: [],
            loading: false,
            headers: [
                {
                    text: "ID #",
                    align: "start",
                    sortable: true,
                    value: "user.emp_plantilla.EPno",
                },
                { text: "Name", value: "name" },
                { text: "From", value: "from" },
                { text: "To", value: "to" },
                { text: "Rating", value: "rating" },
                { text: "Equivalent", value: "equivalent" },
                {
                    text: "Department",
                    value: "user.emp_plantilla.department.name",
                    align: " d-none",
                    filter: this.departmentFilter,
                },
                {
                    text: "Gender",
                    value: "user.pds_personal.sex",
                    align: " d-none",
                    filter: this.genderFilter,
                },
                { text: "Actions", value: "actions", align: "center" },
            ],
            users: [],
        };
    },
    methods: {
        async deletePMS(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/hr/pms/" + id)
                    .then((resp) => {
                        window.location.reload();
                    })
                    .catch((error) => {});
            }
        },
        getData() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getEmployee").then((response) => {
                    this.users = response.data;
                    console.log(this.users);
                    this.loading = false;
                });
            }, 1000);
        },
        async getDep() {
            await axios.get("/api/getDepartment").then((response) => {
                let Items = [];
                Items.push("All");
                response.data.map(function (value, key) {
                    Items.push(value.name);
                });
                this.departmentItems = Items;
            });
        },

        // filters
        genderFilter(value) {
            if (!this.genderFilterValue || this.genderFilterValue == "All") {
                return true;
            }
            if (value) {
                return (
                    value.toLowerCase() === this.genderFilterValue.toLowerCase()
                );
            }
        },
        departmentFilter(value) {
            if (
                !this.departmentFilterValue ||
                this.departmentFilterValue == "All"
            ) {
                return true;
            }

            if (value) {
                return (
                    value.toLowerCase() ===
                    this.departmentFilterValue.toLowerCase()
                );
            }
        },
    },
    created() {
        this.getData();
        this.getDep();
    },
};
</script>
