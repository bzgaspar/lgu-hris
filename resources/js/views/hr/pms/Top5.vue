<template>
    <v-app style="min-height: 0px !important">
        <v-card>
            <v-card-title>
                <v-row justify-center>
                    <v-col xs="12" class="text-center">
                        <v-text-field
                            type="month"
                            label="Gender"
                            solo
                            dense
                            v-model="from_filter_value"
                        ></v-text-field>
                    </v-col>
                    <v-col xs="12" class="text-center">
                        <v-text-field
                            type="month"
                            label="Gender"
                            solo
                            dense
                            v-model="to_filter_value"
                        ></v-text-field>
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
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            from_filter_value: "",
            to_filter_value: "",
            departmentFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            departmentItems: [],
            selected: [],
            loading: false,
            headers: [
                { text: "Name", value: "name" },
                { text: "From", filter: this.from_filter, value: "from" },
                { text: "To", filter: this.to_filter, value: "to" },
                { text: "Rating", value: "rating" },
                { text: "Equivalent", value: "equivalent" },
                {
                    text: "Department",
                    value: "user.emp_plantilla.department.name",
                    align: " d-none",
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
                    .delete("/HumanResource/pms/" + id)
                    .then((resp) => {
                        window.location.reload();
                    })
                    .catch((error) => {});
            }
        },
        getData() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getTop5").then((response) => {
                    this.users = response.data;
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
        from_filter(value) {
            if (!this.from_filter_value) {
                return true;
            }
            if (value) {
                let val = moment(value, "MM-DD-YYYY").format("MM-YYYY");
                let from = moment(this.from_filter_value, "YYYY-MM-DD").format(
                    "MM-YYYY"
                );
                return val === from;
            }
        },
        to_filter(value) {
            if (!this.to_filter_value) {
                return true;
            }
            if (value) {
                let val = moment(value, "MM-DD-YYYY").format("MM-YYYY");
                let to = moment(this.to_filter_value, "YYYY-MM-DD").format(
                    "MM-YYYY"
                );
                return val === to;
            }
        },
    },
    created() {
        this.getData();
        this.getDep();
    },
};
</script>
