<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-row justify-center>
                    <!-- <v-col xs="12" class="text-center">
                        <v-select
                            :items="genderItems"
                            v-model="genderFilterValue"
                            label="Gender"
                            solo
                            dense
                        ></v-select>
                    </v-col>
                    <v-col xs="12" class="text-center">
                        <v-select
                            :items="departmentItems"
                            v-model="departmentFilterValue"
                            label="Department"
                            solo
                            dense
                        ></v-select>
                    </v-col> -->
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
                :items="publication"
                :search="search"
                :loading="loading"
            >
                <!-- <template v-slot:item.status="{ item }">
                    <span v-if="item.status == 1" class="badge bg-warning"
                        >Pending</span
                    >
                    <span v-else-if="item.status == 2" class="badge bg-success"
                        >Accepted</span
                    >
                    <span v-else-if="item.status == 3" class="badge bg-danger"
                        >Rejected</span
                    >
                </template> -->
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Accept"
                        @click="editPublication(item.id)"
                    >
                        <i class="fa-solid fa-pen-to-square"></i
                        > </v-btn
                    ><v-btn v-if="item.document"
                        @click="viewDocument(item.document)"
                        color="indigo"
                        small
                        outlined
                        title="View"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </v-btn>
                    <v-btn
                        v-if="item.status == 0"
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deletePublication(item.id)"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </v-btn>
                    <v-btn
                        v-else
                        color="dark"
                        small
                        outlined
                        title="Deactivate"
                        @click="deletePublication(item.id)"
                    >
                        <i class="fa-solid fa-trash-can"></i>
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
                    text: "ID",
                    align: "start",
                    sortable: true,
                    value: "id",
                },
                { text: "Title", align: "center", value: "title" },
                { text: "Item No", align: "center", value: "itemno" },
                { text: "Monthly", align: "center", value: "monthly" },
                { text: "Salary Grade", align: "center", value: "salarygrade" },
                { text: "Assignment", align: "center", value: "assignment" },
                { text: "Actions", align: "center", value: "actions" },
            ],
            publication: [],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getPublication").then((response) => {
                    this.publication = response.data;
                });
                this.loading = false;
            }, 1000);
        },
        editPublication(id) {
            window.location.href = "/HumanResource/publication/" + id + "/edit";
        },
        deletePublication(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/HumanResource/publication/" + id)
                    .then((resp) => {
                        window.location.reload();
                    })
                    .catch((error) => {});
            }
        },
        viewDocument(document) {
            let url= "/storage/publicationFiles/" + document;
            window.open(url, '_blank', 'noreferrer');
        },
        // filters
        // genderFilter(value) {
        //     if (!this.genderFilterValue || this.genderFilterValue == "All") {
        //         return true;
        //     }
        //     if (value) {
        //         return (
        //             value.toLowerCase() === this.genderFilterValue.toLowerCase()
        //         );
        //     }
        // },
        // departmentFilter(value) {
        //     if (
        //         !this.departmentFilterValue ||
        //         this.departmentFilterValue == "All"
        //     ) {
        //         return true;
        //     }

        //     if (value) {
        //         return (
        //             value.toLowerCase() ===
        //             this.departmentFilterValue.toLowerCase()
        //         );
        //     }
        // },
    },
    created() {
        this.loadTable();
    },
};
</script>
