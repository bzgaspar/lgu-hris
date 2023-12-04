<template>
    <v-app>
        <v-data-table
            :headers="headers"
            :items="leave_credit"
            :loading="loading"
        >
        </v-data-table>
    </v-app>
</template>

<script>
export default {
    props: ["user_id"],
    data() {
        return {
            loading: false,
            leave_credit: [],
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
            ],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios
                    .get("/api/getLeaveCredit/" + this.user_id)
                    .then((response) => {
                        this.leave_credit = response.data;
                    });
                this.loading = false;
            }, 1000);
        },
    },
    created() {
        this.loadTable();
    },
};
</script>
