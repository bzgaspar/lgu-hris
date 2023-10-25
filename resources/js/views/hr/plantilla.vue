<template>
    <v-app>
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
            <v-row class="mb-2 justify-content-end mx-2">
                <v-col class="text-end">
                    <v-btn color="error" outlined @click="DeleteAll()">
                        <i class="fa-solid fa-trash-can me-1"></i>
                        Delete All ({{ selected.length }})
                    </v-btn>
                </v-col>
            </v-row>
            <v-data-table
                v-model="selected"
                :headers="headers"
                :items="plantilla"
                show-select
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.stat="{ item }">
                    <span v-if="item.status == 1" class="badge bg-success"
                        >Permanent</span
                    >
                    <span
                        v-else-if="item.status == 2"
                        class="badge bg-secondary"
                        >Co-terminus</span
                    >
                    <span v-else-if="item.status == 3" class="badge bg-primary"
                        >Casual</span
                    >
                    <span v-else-if="item.status == 4" class="badge bg-warning"
                        >Appointed</span
                    >
                    <span v-else-if="item.status == 5" class="badge bg-info"
                        >Elective</span
                    >
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Add Tardiness"
                        @click="editPlantilla(item.id)"
                    >
                        <i class="fa-solid fa-pen me-1"></i>
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete Plantilla"
                        @click="deletePlantilla(item.id)"
                    >
                        <i class="fa-solid fa-trash me-1"></i>
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
                // {
                //     text: "id",
                //     align: "start",
                //     sortable: true,
                //     value: "id",
                // },
                { text: "ID no", value: "EPno" },
                { text: "Position Title", value: "EPposition" },
                { text: "Incumbent", value: "name" },
                {
                    text: "Gender",
                    value: "user.pds_personal.sex",
                    filter: this.genderFilter,
                    align: " d-none",
                },
                {
                    text: "Department",
                    filter: this.departmentFilter,
                    value: "department.name",
                },
                {
                    text: "Designation",
                    filter: this.departmentFilter,
                    value: "designation.name",
                },
                {
                    text: "Status",
                    value: "stat",
                },
                { text: "Action", value: "actions" },
            ],
            plantilla: [],
        };
    },
    methods: {
        deletePlantilla(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/HumanResource/plantilla/" + id)
                    .then((resp) => {
                        window.location.reload();
                    })
                    .catch((error) => {});
            }
        },
        DeleteAll() {
            let id = [];
            if (this.selected) {
                this.selected.map(function (value, key) {
                    id.push(Number(value.id));
                });

                if (confirm("Are you sure?")) {
                    axios
                        .delete("/HumanResource/plantilla/" + id)
                        .then((resp) => {
                            window.location.reload();
                        })
                        .catch((error) => {});
                }
            }
        },
        editPlantilla(id) {
            (window.location.href = "/HumanResource/plantilla/" + id + "/edit"),
                "_blank",
                "noreferrer";
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
    async created() {
        this.loading = true;
        await setTimeout(() => {
            axios.get("/api/getPlantilla").then((response) => {
                this.plantilla = response.data;
                this.loading = false;
            });
        }, 1000);
        await axios.get("/api/getDepartment").then((response) => {
            let Items = [];
            Items.push("All");
            response.data.map(function (value, key) {
                Items.push(value.name);
            });
            this.departmentItems = Items;
        });
    },
};
</script>
