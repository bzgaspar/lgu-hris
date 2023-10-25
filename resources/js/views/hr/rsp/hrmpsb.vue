<template>
    <v-app>
        <v-form @submit.prevent="addUserHRMPSB()">
            <v-row class="w-75 mx-auto">
                <v-col cols="12" md="5">
                    <v-combobox
                        clearable
                        :items="users"
                        item-text="name"
                        item-value="id"
                        outlined
                        color="success"
                        v-model="form.user_id"
                        prepend-inner-icon="mdi-account"
                        label="HRMPSB Member"
                        dense
                    >
                    </v-combobox>
                </v-col>
                <v-col cols="12" md="5">
                    <v-text-field
                        clearable
                        outlined
                        color="success"
                        v-model="form.position"
                        prepend-inner-icon="mdi-account"
                        label="Position"
                        dense
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn
                        :loading="loading_btn"
                        :disabled="loading_btn"
                        class="w-100"
                        color="success"
                        prepend-icon="mdi-plus"
                        type=""
                        >Add</v-btn
                    >
                </v-col>
            </v-row>
        </v-form>
        <v-row class="justify-content-end">
            <v-col cols="12" md="4">
                <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
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
            :items="hrmpsb"
            :search="search"
            :loading="loading"
        >
            <template v-slot:item.actions="{ item }">
                <v-btn
                    color="error"
                    small
                    outlined
                    :loading="loading_btn_dlt"
                    :disabled="loading_btn_dlt"
                    title="Add Tardiness"
                    @click="deleteRecord(item.id)"
                >
                    <i class="fa-solid fa-trash-can me-1"></i>Delete
                </v-btn>
            </template>
        </v-data-table>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            search: "",
            form: {},
            loading: false,
            loading_btn: false,
            loading_btn_dlt: false,
            headers: [
                {
                    text: "ID",
                    align: "start",
                    sortable: false,
                    value: "id",
                },
                { text: "Name", value: "name" },
                { text: "Position", value: "position" },
                { text: "Action", value: "actions" },
            ],
            users: [],
            hrmpsb: [],
        };
    },
    methods: {
        getUsers() {
            axios.get("/api/getAllUser").then((response) => {
                let Items = [];
                response.data.map(function (value, key) {
                    Items.push({ id: value.id, name: value.name });
                });
                this.users = Items;
                this.loading = false;
            });
        },
        addUserHRMPSB() {
            this.loading_btn = true;
            axios.post("/HumanResource/hrmpsb", this.form).then((response) => {
                if (this.$root.vtoast) {
                    this.$root.vtoast.show({
                        message: "HRMPSB Added!",
                        color: "success",
                        icon: "mdi-exclamation",
                    });
                }
                this.getHRMPSB();
                this.form.user_id = "";
                this.form.position = "";
            });
        },
        getHRMPSB() {
            this.loading = true;
            setTimeout(() => {
                axios.get("/api/getHrmpsbUser").then((response) => {
                    this.hrmpsb = response.data;
                    this.loading = false;
                    this.loading_btn = false;
                    this.loading_btn_dlt = false;
                });
            }, 1000);
        },
        deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                this.loading_btn_dlt = true;
                axios.delete("/HumanResource/hrmpsb/" + id).then((response) => {
                    this.getHRMPSB();
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "HRMPSB Has been deleted!",
                            color: "error",
                            icon: "mdi-exclamation",
                        });
                    }
                });
            }
        },
    },
    async created() {
        this.getUsers();
        this.getHRMPSB();
    },
};
</script>
