<template>
    <v-app>
        <v-card>
            <v-card-title
                ><v-row>
                    <v-col cols="auto">
                        <v-checkbox
                            v-model="indigenous"
                            label="Indigenous"
                            color="success"
                            value="Indigenous"
                            hide-details
                        ></v-checkbox>
                    </v-col>
                    <v-col cols="auto">
                        <v-checkbox
                            v-model="pwd"
                            label="PWD"
                            color="success"
                            value="PWD"
                            hide-details
                        ></v-checkbox>
                    </v-col>
                    <v-col cols="auto"
                        ><v-checkbox
                            v-model="single"
                            label="Single Parent"
                            color="success"
                            value="Single Parent"
                            hide-details
                        ></v-checkbox>
                    </v-col>
                </v-row>
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
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
            >
                <template v-slot:item.index="{ item, index }">
                    {{ index + 1 }}
                </template>
                <template v-slot:item.indigenous="{ item, index }">
                    <span v-if="item.Q40a"> No </span>
                    <span v-else>{{ item.Q40a1 }}</span>
                </template>
                <template v-slot:item.pwd="{ item, index }">
                    <span v-if="item.Q40b"> No </span>
                    <span v-else>{{ item.Q40b1 }}</span>
                </template>
                <template v-slot:item.single="{ item, index }">
                    <span v-if="item.Q40c"> No </span>
                    <span v-else>{{ item.Q40c1 }}</span>
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
                    <v-btn
                        color="success"
                        small
                        outlined
                        title="Accept"
                        @click="viewAccept(item.id)"
                    >
                        <i class="fa-solid fa-check me-1"></i>Accept
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Reject"
                        @click="viewReject(item.id)"
                    >
                        <i class="fa-solid fa-check me-1"></i>Reject
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
            genderFilterValue: "",
            publicationFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            publicationItems: [],
            indigenous: null,
            pwd: null,
            single: null,
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
                    text: "Gender",
                    value: "sex",
                    align: "center",
                    filter: this.genderFilter,
                },
                {
                    text: "Indigenous ",
                    align: "center",
                    value: "indigenous",
                    sortable: false,
                },
                {
                    text: "IndigenousFilter",
                    value: "Q40a",
                    align: " d-none",
                    filter: this.indigenousFilter,
                },
                {
                    text: "PWDFilter",
                    value: "Q40b",
                    align: " d-none",
                    filter: this.pwdFilter,
                },
                {
                    text: "SinglePFilter",
                    value: "Q40c",
                    align: " d-none",
                    filter: this.singleFilter,
                },
                { text: "PWD", align: "center", value: "pwd", sortable: false },
                {
                    text: "Single Parent",
                    align: "center",
                    value: "single",
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
            window.location.href = "/hr/applicant/" + id;
        },
        viewAccept(id) {
            const answer = window.confirm(
                "Do you really want to accept this applicant?"
            );
            if (answer) {
                window.location.href = "/hr/manage_applicants/" + id + "/edit";
            }
        },
        viewReject(id) {
            const answer = window.confirm(
                "Do you really want to Reject this applicant?"
            );
            if (answer) {
                axios.delete("/hr/manage_applicants/" + id).then((response) => {
                    this.fetchApplication();
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Applicant has been rejected!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
            }
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
        indigenousFilter(value) {
            if (!this.indigenous || this.indigenous == null) {
                return true;
            } else {
                return value === null;
            }
        },
        pwdFilter(value) {
            if (!this.pwd || this.pwd == null) {
                return true;
            } else {
                return value === null;
            }
        },
        singleFilter(value) {
            if (!this.single || this.single == null) {
                return true;
            } else {
                return value === null;
            }
        },
        async fetchApplication() {
            this.loading = true;
            await axios.get("/api/getPublication").then((response) => {
                let Items = [];
                Items.push("All");
                response.data.map(function (value, key) {
                    Items.push(value.title);
                });
                this.publicationItems = Items;
            });
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
                    .catch((error) => {});
            }, 1000);
        },
    },
    async created() {
        this.fetchApplication();
    },
};
</script>
