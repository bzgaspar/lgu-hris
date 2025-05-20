<template>
    <v-app style="min-height: 0px !important">
        <v-row height="50px">
            <v-col cols="12" md="6" class="border border-black rounded">
                Employee Plantilla <br />
                <v-btn
                    color="success"
                    small
                    outlined
                    title="View Employee Plantilla"
                    @click="goToPrint('HumanResource/plantilla/create')"
                >
                    <i class="fa-solid fa-print me-1"></i>Print
                </v-btn>
                <pie-chart :data="chartData[1]"></pie-chart>
            </v-col>
            <v-col cols="12" md="6" class="border border-black rounded">
                PWD , Indigenous and Single Parent<br />
                <v-btn
                    color="success"
                    small
                    outlined
                    title="View Employee Specials"
                    @click="goToPrint('HumanResource/ViewPwdSpI')"
                >
                    <i class="fa-solid fa-print me-1"></i>Print
                </v-btn>

                <pie-chart :data="chartData[2]"></pie-chart>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="6" class="border border-black rounded">
                Gender<br />
                <v-btn
                    color="success"
                    small
                    outlined
                    title="View Employee Genders"
                    @click="goToPrint('HumanResource/ViewByGenderCount')"
                >
                    <i class="fa-solid fa-print me-1"></i>Print
                </v-btn>

                <pie-chart :data="chartData[3]"></pie-chart>
            </v-col>
            <v-col cols="12" md="6" class="border border-black rounded">
                Religion<br />
                <v-btn
                    color="success"
                    small
                    outlined
                    title="View Employee Plantilla"
                    @click="goToPrint('HumanResource/PrintReligions')"
                >
                    <i class="fa-solid fa-print me-1"></i>Print
                </v-btn>

                <pie-chart :data="chartData[0]"></pie-chart>
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
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="success"
                        small
                        outlined
                        title="View Emp"
                        @click="ViewProfile(item.id)"
                    >
                        <!-- <v-icon>mdi-eye</v-icon> -->
                        <i class="fa-solid fa-eye me-1"></i>View
                    </v-btn>
                    <v-btn
                        color="primary"
                        small
                        outlined
                        title="View COE"
                        @click="openCOE(item.id)"
                    >
                        <!-- <v-icon>mdi-eye</v-icon> -->
                        <i class="fa-solid fa-print me-1"></i>COE
                    </v-btn>
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="View COE"
                        @click="openPDS(item.id)"
                    >
                        <!-- <v-icon>mdi-eye</v-icon> -->
                        <i class="fa-solid fa-eye me-1"></i>PDS
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
                { text: "Position", value: "emp_plantilla.EPposition" },
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
        openCOE(id) {
            window.open(
                "/HumanResource/dashboard/" + id,
                "_blank",
                "noreferrer"
            );
        },
        openPDS(id) {
            window.open("/users/pds/" + id + "/print", "_blank", "noreferrer");
        },
        getData() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getAllUser").then((response) => {
                    this.users = response.data;
                    this.loading = false;
                });
            }, 1000);
        },
        goToPrint(link) {
            window.open(`/${link}`, "_blank", "noreferrer");
        },
        getChartEMP() {
            axios.get("/api/getChartEMP").then((response) => {
                this.chartData = response.data;
            });
        },
        ViewProfile(id) {
            window.open("/ProfileView/" + id, "_blank");
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
        this.getChartEMP();
    },
};
</script>
