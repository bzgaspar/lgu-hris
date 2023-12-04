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
                    value: "from",
                },
                {
                    text: "To",
                    align: "center",
                    sortable: false,
                    value: "to",
                },
                {
                    text: "Designation",
                    align: "center",
                    sortable: false,
                    value: "designation",
                },
                {
                    text: "Status",
                    align: "center",
                    sortable: false,
                    value: "status",
                },
                {
                    text: "Salary",
                    align: "center",
                    sortable: false,
                    value: "salary",
                },
                {
                    text: "W/O Pay",
                    align: "center",
                    sortable: false,
                    value: "wo_pay",
                },
                {
                    text: "Date",
                    align: "center",
                    sortable: false,
                    value: "date",
                },
                {
                    text: "Cause",
                    align: "center",
                    sortable: false,
                    value: "cause",
                },
            ],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios
                    .get("/api/getUserServiceRecord/" + this.user_id)
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
