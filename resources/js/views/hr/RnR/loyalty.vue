<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-row justify-center>
                    <v-col xs="12" class="text-end">
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
                :items="employees"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.next_loyalty_new="{ item }">
                    {{ getDateOnly(item.next_loyalty) }}
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            employees: [],
            loading: false,
            headers: [
                { text: "Name", value: "emp_name" },
                {
                    text: "Position",
                    value: "EPposition",
                },
                {
                    text: "Department",
                    value: "name",
                },
                {
                    text: "Years in Service",
                    value: "year_difference",
                },
                { text: "Next Loyalty Pay", value: "next_loyalty_new" },
            ],
            application: [],
        };
    },
    methods: {
        getDateOnly(date){
            return moment(date).format('MMMM d, Y')
        },
    },
    async created() {
        this.loading = true;
        await setTimeout(() => {
            axios.get("/api/getLoyalty").then((response) => {
                this.employees = response.data;
                this.loading = false;
            });
        }, 1000);
    },
};
</script>
