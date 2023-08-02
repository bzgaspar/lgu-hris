<template>
    <v-app style="min-height: 0px !important">
        <v-row height="50px" class="justify-center">
            <v-col cols="12" md="6" class="border border-black rounded">
                Vaccination
                <pie-chart :data="chartData"></pie-chart>
            </v-col>
        </v-row>
        <v-card class="mt-5">
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
            <v-data-table
                :headers="headers"
                :items="users"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.vax_stage="{ item }">
                    <v-chip
                        v-if="item.booster === '1'"
                        class="ma-2"
                        color="primary"
                        small
                        >1st Dose</v-chip
                    >
                    <v-chip
                        v-if="item.booster === '2'"
                        class="ma-2"
                        color="error"
                        small
                        >2nd Dose</v-chip
                    >
                    <v-chip
                        v-if="item.booster === '3'"
                        class="ma-2"
                        color="orange"
                        small
                        >1st Booster</v-chip
                    >
                    <v-chip
                        v-if="item.booster === '4'"
                        class="ma-2"
                        color="success"
                        small
                        >2nd Booster</v-chip
                    >
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        v-if="item.photo"
                        color="orange"
                        small
                        outlined
                        title="View COE"
                        @click="viewVac(item)"
                    >
                        <i class="fa-solid fa-eye me-1"></i>Vax Card
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
            chartData: [],
            selected: [],
            loading: false,
            headers: [
                {
                    text: "id",
                    align: "start",
                    sortable: true,
                    value: "id",
                },
                { text: "Name", value: "name" },
                { text: "Position", value: "vax_stage" },
                {
                    text: "Department",
                    value: "emp_plantilla.department.name",
                    align: " d-none",
                    filter: this.departmentFilter,
                },
                {
                    text: "Gender",
                    value: "pds_personal.sex",
                    align: " d-none",
                    filter: this.genderFilter,
                },
                { text: "Actions", value: "actions", align: "center" },
            ],
            users: [],
        };
    },
    methods: {
        viewVac(item) {
            window.open("/storage/Vcard/" + item.photo, "_blank", "noreferrer");
        },
        getData() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/fetchCovidResponse").then((response) => {
                    this.users = response.data;
                    this.loading = false;

                    let vax_level = {
                        "1st_Dose": 0,
                        "2nd_Dose": 0,
                        "1st_Booster": 0,
                        "2nd_Booster": 0,
                    };

                    response.data.map(function (value, key) {
                        if (value.booster === "1") {
                            vax_level["1st_Dose"]++;
                        } else if (value.booster === "2") {
                            vax_level["2nd_Dose"]++;
                        } else if (value.booster === "3") {
                            vax_level["1st_Booster"]++;
                        } else if (value.booster === "4") {
                            vax_level["2nd_Booster"]++;
                        }
                    });
                    this.chartData = vax_level;
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
    created() {
        this.getData();
        this.getDep();
    },
};
</script>
