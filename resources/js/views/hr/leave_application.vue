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
                        <v-select
                            :items="departmentItems"
                            v-model="departmentFilterValue"
                            label="Department"
                            solo
                            dense
                        ></v-select>
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
                :items="leave_app"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.status="{ item }">
                    <span v-if="item.status == 1" class="badge bg-warning"
                        >Pending</span
                    >
                    <span v-else-if="item.status == 2" class="badge bg-success"
                        >Accepted</span
                    >
                    <span v-else-if="item.status == 3" class="badge bg-danger"
                        >Rejected</span
                    >
                </template>
                <template v-slot:item.date="{ item }">
                    {{ item.created_at | formatDate }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        v-if="item.status == 1"
                        color="success"
                        small
                        outlined
                        title="Accept"
                        @click="accept_reject(item.id, 1)"
                    >
                        <i class="fa-solid fa-check"></i>
                    </v-btn>
                    <v-btn
                        v-if="item.status == 1"
                        color="error"
                        small
                        outlined
                        title="Reject"
                        @click="accept_reject(item.id, 2)"
                    >
                        <i class="fa-solid fa-x"></i>
                    </v-btn>
                    <v-btn
                        color="primary"
                        small
                        outlined
                        title="Print"
                        @click="viewLeaveCard(item.id)"
                    >
                        <i class="fa-solid fa-print"></i>
                    </v-btn>
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Dlete"
                        @click="deleteLeaveCard(item.id)"
                    >
                        <i class="fa-solid fa-trash"></i>
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
                { text: "Name", value: "name" },
                { text: "Type", value: "type" },
                {
                    text: "Department",
                    value: "users.emp_plantilla.department.name",

                    filter: this.departmentFilter,
                },
                {
                    text: "Gender",
                    value: "users.pds_personal.sex",

                    filter: this.genderFilter,
                },
                {
                    text: "From",
                    value: "date_from",
                },
                {
                    text: "To",
                    value: "date_to",
                },
                { text: "Date Filed", value: "date" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            leave_app: [],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getLeaveApp").then((response) => {
                    this.leave_app = response.data;
                });
                this.loading = false;
            }, 1000);
        },
        viewLeaveCard(id) {
            window.open("/users/myleave/" + id, "_blank", "noreferrer");
        },
        accept_reject(id, a_r) {
            let uri = "";
            if (confirm("Are you Sure?")) {
                if (a_r == 1) {
                    uri = "/" + id;
                } else if (a_r == 2) {
                    uri = "/" + id + "/edit";
                }
                axios
                    .get("/HumanResource/leaveApplication" + uri)
                    .then((response) => {
                        this.loadTable();
                    });
            }
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
        deleteLeaveCard(id) {
            if (confirm("Are you sure?")) {
                axios
                    .post("/HumanResource/leaveApplication/" + id, {
                        _method: "DELETE",
                    })
                    .then((response) => {
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Leave Credit Deleted!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
                        }
                        this.loadTable();
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
        this.getDep();
    },
};
</script>
