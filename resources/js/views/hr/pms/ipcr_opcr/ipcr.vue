<template>
    <div class="mt-3">
        <v-row justify-end>
            <v-col xs="12">
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
        <v-data-table
            :headers="headers"
            :items="forms"
            :loading="loading"
            :search="search"
        >
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
    data() {
        return {
            headers: [
                { text: "Name", value: "name" },
                { text: "From", value: "from" },
                { text: "To", value: "to" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            form: {
                question: null,
                type: null,
            },
            forms: [],
            search: null,
            valid: false,
            loading: false,
        };
    },
    methods: {
        async getIpcrs() {
            this.loading = true;
            await axios.get("/api/getIPCR").then((response) => {
                this.forms = response.data;
                this.loading = false;
            });
        },
        print_ipcr(id) {
            window.open("/users/IPCR/" + id, "_blank", "noreferrer");
        },
        delete_ipcr(id) {
            if (confirm("Are you sure you want to delete this IPCR?")) {
                axios
                    .post("/users/IPCR/" + id, {
                        _method: "DELETE",
                    })
                    .then((response) => {
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
