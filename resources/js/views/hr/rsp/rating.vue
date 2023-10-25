<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-row justify-center>
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
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
            >
                <template v-slot:item.index="{ item, index }">
                    {{ index + 1 }}
                </template>
                <template v-slot:item.indigenous="{ item, index }">
                    <span v-if="item.user.pds_other.Q40a"> No </span>
                    <span v-else>{{ item.user.pds_other.Q40a1 }}</span>
                </template>
                <template v-slot:item.pwd="{ item, index }">
                    <span v-if="item.user.pds_other.Q40b"> No </span>
                    <span v-else>{{ item.user.pds_other.Q40b1 }}</span>
                </template>
                <template v-slot:item.single="{ item, index }">
                    <span v-if="item.user.pds_other.Q40c"> No </span>
                    <span v-else>{{ item.user.pds_other.Q40c1 }}</span>
                </template>
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
            sortBy: "total",
            sortDesc: true,
            search: "",
            publicationFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            publicationItems: [],
            headers: [
                {
                    text: "Rank",
                    align: "start",
                    sortable: false,
                    value: "index",
                },
                {
                    text: "Name",
                    value: "name",
                    sortable: false,
                    align: "center",
                },
                {
                    text: "Position",
                    filter: this.positionFilter,
                    value: "publication.title",
                    align: "center",
                    sortable: false,
                },
                {
                    text: "Total Points",
                    align: "center",
                    value: "total",
                    sortable: false,
                },
                {
                    text: "Action",
                    value: "actions",
                    align: "center",
                    sortable: false,
                },
            ],
            application: [],
        };
    },
    methods: {
        viewApplicant(id) {
            window.location.href = "/HumanResource/applicant/" + id;
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
            axios
                .get("/api/getRanking")
                .then((response) => {
                    let listOfObjects = Object.keys(response.data).map(
                        (key) => {
                            return response.data[key];
                        }
                    );
                    this.application = listOfObjects;
                    this.loading = false;
                })
                .catch((error) => {
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
