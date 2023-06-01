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
                :items="service_record"
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
                        v-if="item.emp_plantilla"
                        color="orange"
                        small
                        outlined
                        title="Edit"
                        @click="editServiceRecord(item.id)"
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </v-btn>
                    <v-btn
                        color="primary"
                        small
                        outlined
                        title="Print"
                        @click="viewServiceRecord(item.id)"
                    >
                        <i class="fa-solid fa-print"></i>
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
                { text: "Name", align: "center",value: "name" },
                { text: "Designation", align: "center",value: "emp_plantilla.designation.name" },
                { text: "Actions", align: "center",value: "actions" },
            ],
            service_record: [],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getServiceRecord").then((response) => {
                    this.service_record = response.data;
                });
                this.loading = false;
            }, 1000);
            axios.get("/api/getDepartment").then((response) => {
                let Items = [];
                Items.push("All");
                response.data.map(function (value, key) {
                    Items.push(value.name);
                });
                this.departmentItems = Items;
            });
        },
        viewServiceRecord(id) {
            window.open("/hr/service/" + id+'/edit', "_blank", "noreferrer");
        },
        editServiceRecord(id) {
            window.location.href = "/hr/service/"+ id;
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
        this.loadTable();
    },
};
</script>
