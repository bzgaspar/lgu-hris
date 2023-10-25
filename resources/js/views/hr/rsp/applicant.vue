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
                            :items="publicationItems"
                            v-model="publicationFilterValue"
                            label="Position"
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
                :items="application"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Add Tardiness"
                        @click="viewApplicant(item.id)"
                    >
                        <i class="fa-solid fa-eye me-1"></i>View
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
            publicationFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            publicationItems: [],
            loading: false,
            headers: [
                {
                    text: "ID",
                    align: "start",
                    sortable: false,
                    value: "id",
                },
                { text: "Name", value: "name" },
                {
                    text: "Gender",
                    value: "user.pds_personal.sex",
                    filter: this.genderFilter,
                },
                {
                    text: "Position",
                    filter: this.positionFilter,
                    value: "publication.title",
                },
                { text: "Action", value: "actions" },
            ],
            application: [],
        };
    },
    methods: {
        viewApplicant(id){
            window.location.href="/HumanResource/applicant/" +id
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
        positionFilter(value) {
            if (
                !this.publicationFilterValue ||
                this.publicationFilterValue == "All"
            ) {
                return true;
            }
            if (value) {
                return (
                    value.toLowerCase() ===
                    this.publicationFilterValue.toLowerCase()
                );
            }
        },
    },
    async created() {
        this.loading = true;
        await setTimeout(() => {
            axios.get("/api/getApplicants").then((response) => {
                this.application = response.data;
                this.loading = false;
            });
        }, 1000);
        await axios.get("/api/getPublication").then((response) => {
            let Items = [];
            Items.push("All");
            response.data.map(function (value, key) {
                Items.push(value.title);
            });
            this.publicationItems = Items;
        });
    },
};
</script>
