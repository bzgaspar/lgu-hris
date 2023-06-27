<template>
    <v-app>
        <v-row class="justify-end">
            <v-col cols="12" md="3" class="text-center">
                <v-combobox
                    :items="Years"
                    v-model="YearFilterValue"
                    label="Year"
                    solo
                    dense
                    clearable
                ></v-combobox>
            </v-col>
            <v-col cols="12" md="3" class="text-center">
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
        <v-data-table
            :headers="headers"
            :items="yearlyIPCR"
            :search="search"
            :loading="loading"
        >
        </v-data-table>
    </v-app>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            Years: [],
            yearlyIPCR: [],
            YearFilterValue: null,
            departmentItems: [],
            loading: false,
            FieldRequired: [(v) => !!v || "This field is required"],
            NumberField: [
                (v) => !!v || "This field is required",
                (v) => (v >= 0 && v <= 5) || "0 to 100 is valid",
            ],
            headers: [
                { text: "Rank", value: "rank" },
                { text: "Department", value: "dep_name" },
                { text: "Year", filter: this.yearFilter, value: "year" },
                { text: "Rating", value: "rating" },
            ],
        };
    },
    methods: {
        async getYearsIPCR() {
            await axios.get("/api/getYearsIPCR2").then((response) => {
                let Items = [];
                response.data.map(function (value) {
                    Items.push(value);
                });
                this.Years = Items;
            });
        },
        async getYearlyRating() {
            this.loading = true;
            await axios.get("/api/getYearlyTopRating").then((response) => {
                let Items = [];
                let rank = 1;
                response.data.map(function (value, key) {
                    Items.push({
                        dep_name: value.dep_name,
                        year: value.year,
                        rating: value.rating,
                        rank: rank,
                    });
                    rank++;
                });
                this.yearlyIPCR = Items;
                this.loading = false;
            });
        },
        // filters
        yearFilter(value) {
            if (!this.YearFilterValue) {
                return true;
            }
            if (value) {
                return value === this.YearFilterValue;
            }
        },
    },
    created() {
        this.getYearsIPCR();
        this.getYearlyRating();
    },
};
</script>
