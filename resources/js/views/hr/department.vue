<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-row justify-center>
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
                :items="department"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Accept"
                        @click="editDepartment(item.id)"
                    >
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deleteDepartment(item.id)"
                    >
                        <i class="fa-solid fa-trash me-1"></i> Delete
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
            loading: false,
            headers: [
                {
                    text: "ID",
                    align: "start",
                    sortable: true,
                    value: "id",
                    align: " d-none",
                },
                { text: "Dep Id", align: "center", value: "dep_id" },
                { text: "Name", align: "center", value: "name" },
                { text: "Actions", align: "center", value: "actions" },
            ],
            department: [],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getDepartment").then((response) => {
                    this.department = response.data;
                });
                this.loading = false;
            }, 1000);
            // axios.get("/api/getDepartment").then((response) => {
            //     let Items = [];
            //     Items.push("All");
            //     response.data.map(function (value, key) {
            //         Items.push(value.name);
            //     });
            //     this.departmentItems = Items;
            // });
        },
        editDepartment(id) {
            window.location.href =
                "/HumanResource/department/" + id + "/edit";
        },
        deleteDepartment(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/HumanResource/department/" + id)
                    .then((resp) => {
                        window.location.reload();
                    })
                    .catch((error) => {});
            }
        },
    },
    created() {
        this.loadTable();
    },
};
</script>
