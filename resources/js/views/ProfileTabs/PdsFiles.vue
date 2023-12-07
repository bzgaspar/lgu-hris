<template>
    <v-app>
        <v-data-table
            :headers="headers"
            :items="files"
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
    props: ["user_id", "user_role"],
    data() {
        return {
            loading: false,
            files: [],
            headers: [
                {
                    text: "Document",
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
                    .get("/api/getUserPdsFiles/" + this.user_id)
                    .then((response) => {
                        this.files = response.data;
                    });
                this.loading = false;
            }, 1000);
        },
        showFile(document) {
            window.open(
                "/storage/pdsFiles/" + document,
                "_blank",
                "noreferrer"
            );
        },
    },
    created() {
        this.loadTable();
    },
};
</script>

<style lang="scss" scoped></style>
