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
                    <i class="fa-solid fa-print me-1"></i>Print
                </v-btn>
                <v-btn
                    class="border border-warning text-warning"
                    small
                    outlined
                    title="Edit"
                    @click="edit_ipcr(item.id)"
                >
                    <i class="fa-solid fa-pen me-1"></i>Edit
                </v-btn>
                <v-btn
                    class="border border-danger text-danger"
                    small
                    outlined
                    title="Delete"
                    @click="delete_ipcr(item.id)"
                >
                    <i class="fa-solid fa-trash me-1"></i>Delete
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
export default {
    props: {
        user_id: String, // Define the prop data type
    },
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
        edit_ipcr(id) {
            if (confirm("Are you sure you want to edit this IPCR?")) {
                window.location.href = "/users/IPCR/" + id + "/edit";
            }
        },
        print_ipcr(id) {
            window.location.href = "/users/IPCR/" + id;
        },
        delete_ipcr(id) {
            if (confirm("Are you sure you want to delete this IPCR?")) {
                axios.delete("/users/IPCR/" + id).then((response) => {
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "IPCR has been Deleted!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                    this.getIpcrs();
                });
            }
        },
    },
    created() {
        this.getIpcrs();
    },
};
</script>
