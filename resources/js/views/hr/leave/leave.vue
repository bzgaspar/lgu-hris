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
                :items="users"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="primary"
                        small
                        outlined
                        title="Add Tardiness"
                        @click="addTardiness(item)"
                    >
                        <i class="fa-solid fa-plus me-1"></i>Tardiness
                    </v-btn>
                </template>
            </v-data-table>
            <Modal :show_modal.sync="show_modal" @close="closeModal">
                <template #header> Tardiness | {{ employee_name }} </template>
                <template #content>
                    <Tardiness
                        v-if="show_tardiness"
                        @close="resetForm"
                        @edit="editForm"
                        :leave_card_id.sync="leave_card_id"
                        :show_modal.sync="show_modal"
                    ></Tardiness>
                    <EditTardiness
                        v-else-if="edit_tardiness"
                        @close="cancelEdit"
                        :edit_leave.sync="edit_leave"
                        :show_modal.sync="show_modal"
                    ></EditTardiness>
                </template>
            </Modal>
        </v-card>
    </v-app>
</template>
<script>
import Modal from "../compnents/modal.vue";
import Tardiness from "./leave_credit_calc.vue";
import EditTardiness from "./leave_credit_calc_edit.vue";
export default {
    components: {
        Modal,
        Tardiness,
        EditTardiness,
    },
    data() {
        return {
            search: "",
            genderFilterValue: "",
            departmentFilterValue: "",
            genderItems: ["All", "Male", "Female"],
            departmentItems: [],
            selected: [],
            loading: false,
            show_modal: false,
            show_tardiness: false,
            edit_tardiness: false,
            leave_card_id: null,
            employee_name: null,
            edit_leave: null,
            headers: [
                {
                    text: "id",
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
                { text: "Name", value: "name" },
                { text: "Position", value: "emp_plantilla.EPposition" },
                {
                    text: "VL Balance",
                    value: "leave_creditlatest.elc_vl_balance",
                },
                {
                    text: "SL Balance",
                    value: "leave_creditlatest.elc_sl_balance",
                },
                { text: "Actions", value: "actions", align: "center" },
            ],
            users: [],
        };
    },
    methods: {
        getData() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getLeave").then((response) => {
                    this.users = response.data;
                    this.loading = false;
                });
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
        closeModal() {
            this.show_modal = false;
            this.show_tardiness = false;
            this.edit_tardiness = false;
        },
        cancelEdit() {
            this.show_tardiness = true;
            this.edit_tardiness = false;
        },
        addTardiness(item) {
            // window.location.href = "/hr/leave/" + id;
            this.leave_card_id = item.id;
            this.employee_name = item.name;
            this.show_modal = true;
            this.show_tardiness = true;
        },
        resetForm() {
            // window.location.href = "/hr/leave/" + id;
            this.show_tardiness = false;
            setTimeout(() => {
                this.show_tardiness = true;
            }, 500);
        },
        editForm(item) {
            this.show_tardiness = false;
            this.edit_tardiness = true;
            this.edit_leave = item;
        },
        // viewLeaveCard(id) {
        //     window.open("/hr/leave/" + id + "/edit", "_blank", "noreferrer");
        // },
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
    },
};
</script>
