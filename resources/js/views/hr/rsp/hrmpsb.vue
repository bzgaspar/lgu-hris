<template>
    <v-app>
        <v-form @submit.prevent="addUserHRMPSB()">
            <v-row class="w-75 mx-auto">
                <v-col cols="12" md="8">
                    <v-combobox
                        clearable
                        :items="users"
                        item-text="name"
                        item-value="id"
                        outlined
                        color="success"
                        v-model="user_selected"
                        prepend-inner-icon="mdi-account"
                        label="HRMPSB Member"
                        dense
                    >
                    </v-combobox>
                </v-col>
                <v-col cols="12" md="4">
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
            user_selected: "",
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
            axios.post("/hr/hrmpsb", this.user_selected).then((response) => {
                if (this.$root.vtoast) {
                    this.$root.vtoast.show({
                        message: "HRMPSB Added!",
                        color: "success",
                        icon: "mdi-exclamation",
                    });
                }
                this.getHRMPSB();
                this.user_selected = "";
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
                axios.delete("/hr/hrmpsb/" + id).then((response) => {
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
