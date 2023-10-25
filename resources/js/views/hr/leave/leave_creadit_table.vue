<template>
    <v-app>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="leave_credit"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="orange"
                        small
                        outlined
                        title="Edit"
                        @click="editTardiness(item)"
                    >
                        <i class="fa-solid fa-pen me-1"></i> Edit
                    </v-btn>
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="DeleteTardiness(item)"
                    >
                        <i class="fa-solid fa-pen me-1"></i> Delete
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
export default {
    props: {
        leave_card_id: Number,
    },
    data() {
        return {
            search: "",
            loading: false,
            leave_id: null,
            headers: [
                {
                    text: "From",
                    align: "center",
                    sortable: false,
                    value: "elc_period_from",
                },
                {
                    text: "To",
                    align: "center",
                    sortable: false,
                    value: "elc_period_to",
                },
                {
                    text: "Particulars",
                    align: "center",
                    sortable: false,
                    value: "elc_particular",
                },
                {
                    text: "VL W/ Pay",
                    align: "center",
                    sortable: false,
                    value: "elc_vl_auw_p",
                },
                {
                    text: "VL Balance",
                    align: "center",
                    sortable: false,
                    value: "elc_vl_balance",
                },
                {
                    text: "VL W/O PAY",
                    align: "center",
                    sortable: false,
                    value: "elc_vl_auwo_p",
                },
                {
                    text: "SL W/ Pay",
                    align: "center",
                    sortable: false,
                    value: "elc_sl_auw_p",
                },
                {
                    text: "SL Balance",
                    align: "center",
                    sortable: false,
                    value: "elc_sl_balance",
                },
                {
                    text: "SL W/O PAY",
                    align: "center",
                    sortable: false,
                    value: "elc_sl_auwo_p",
                },
                {
                    text: "Remarks",
                    align: "center",
                    sortable: false,
                    value: "elc_remarks",
                },
                { text: "Actions", align: "center", value: "actions" },
            ],
            leave_credit: [],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios
                    .get("/api/getLeaveCredit/" + this.leave_card_id)
                    .then((response) => {
                        this.leave_credit = response.data;
                    });
                this.loading = false;
            }, 1000);
        },
        editTardiness(item) {
            this.$emit("edit", item);
        },
        DeleteTardiness(item) {
            axios.delete("/HumanResource/leave/" + item.id).then((response) => {
                if (this.$root.vtoast) {
                    this.$root.vtoast.show({
                        message: "Leave Credit Deleted!",
                        color: "success",
                        icon: "mdi-exclamation",
                    });
                }
                this.loadTable();
            });
        },
    },
    created() {
        this.loadTable();
    },
};
</script>
