<template>
    <div class="mt-3">
        <v-data-table :headers="headers" :items="forms" :loading="loading">
            <template v-slot:item.actions="{ item }">
                <v-btn
                    class="border border-success text-success"
                    small
                    outlined
                    title="Edit"
                    @click="print_ipcr(item.id)"
                >
                    <i class="fa-solid fa-eye me-1"></i>View
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
export default {
    props: ["user_id"],
    data() {
        return {
            headers: [
                { text: "From", value: "from" },
                { text: "To", value: "to" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            form: {
                question: null,
                type: null,
            },
            forms: [],
            valid: false,
            loading: false,
        };
    },
    methods: {
        async getIpcrs() {
            this.loading = true;
            await axios
                .get("/api/getIpcrUsers/" + this.user_id)
                .then((response) => {
                    this.forms = response.data;
                    this.loading = false;
                });
        },
        print_ipcr(id) {
            window.open("/users/IPCR/" + id, "_blank", "noreferrer");
        },
    },
    created() {
        this.getIpcrs();
    },
};
</script>
