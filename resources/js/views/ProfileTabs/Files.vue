<template>
    <v-app>
        <v-data-table
            :headers="headers"
            :items="leave_credit"
            :loading="loading"
        >
            <template v-slot:item.view="{ item }">
                <v-btn
                    color="success"
                    small
                    outlined
                    title="View"
                    @click="showFile(item.document)"
                >
                    <i class="fa-solid fa-eye me-1"></i> View
                </v-btn>
            </template>
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
                    text: "Type",
                    align: "center",
                    sortable: false,
                    value: "type",
                },
                {
                    text: "Filename",
                    align: "center",
                    sortable: false,
                    value: "document",
                },
                {
                    text: "View",
                    align: "center",
                    sortable: false,
                    value: "view",
                },
            ],
        };
    },
    methods: {
        loadTable() {
            this.loading = true;
            setTimeout(() => {
                axios
                    .get("/api/getFiles201/" + this.user_id)
                    .then((response) => {
                        this.leave_credit = response.data;
                    });
                this.loading = false;
            }, 1000);
        },
        showFile(document) {
            window.open("/storage/files_201/" + document, "_blank", "noreferrer");
        },
    },
    created() {
        this.loadTable();
    },
};
</script>
