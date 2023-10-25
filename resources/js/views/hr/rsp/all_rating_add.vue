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
                :items="application"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deleteRating(item.id)"
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
            loading: false,
            headers: [
                {
                    text: "App Name",
                    value: "app_name",

                    align: "center",
                },
                {
                    text: "EXP",
                    value: "experience",

                    align: "center",
                },
                {
                    text: "Education",
                    value: "education",

                    align: "center",
                },
                {
                    text: "Eligibility",
                    value: "eligibility",

                    align: "center",
                },
                {
                    text: "Rater Name",
                    value: "rater_name",

                    align: "center",
                },
                {
                    text: "Action",
                    value: "actions",
                    align: "center",
                },
            ],
            application: [],
        };
    },
    methods: {
        deleteRating(id) {
            const answer = window.confirm(
                "Do you really want to Reject this Rating?"
            );
            if (answer) {
                axios.delete("/HumanResource/deleteRatingAdd/" + id).then((response) => {
                    this.fetchRatings();
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Rating has been Delete!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
            }
        },

        async fetchRatings() {
            this.loading = true;
            await setTimeout(() => {
                axios.get("/api/fetchRatingsAdd").then((response) => {
                    this.application = response.data;
                    this.loading = false;
                });
            }, 1000);
        },
    },
    async created() {
        this.fetchRatings();
    },
};
</script>
