<template>
    <v-app>
        <v-form
            @submit.prevent="addYearlyRating"
            v-model="valid"
            ref="formValid"
        >
            <v-row>
                <v-col cols="12" md="2">
                    <v-combobox
                        v-model="form.year"
                        :items="Years"
                        filled
                        placeholder="Year"
                        color="success"
                        label="Year"
                        clearable
                        dense
                        hide-details="auto"
                        @change="getDepartment"
                        :rules="FieldRequired"
                    ></v-combobox>
                </v-col>
                <v-col cols="12" md="">
                    <v-row>
                        <v-col cols="2"
                            >Initial Rating: <br />
                            {{ form.average }}
                        </v-col>
                        <v-col>
                            <v-combobox
                                :items="departmentItems"
                                v-model="form.dep_id"
                                @change="getAverage()"
                                filled
                                dense
                                item-value="id"
                                item-text="name"
                                placeholder="Department"
                                color="success"
                                label="Department"
                                class="w-100"
                                clearable
                                hide-details="auto"
                                :rules="FieldRequired"
                            ></v-combobox>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        v-model="form.add_points"
                        filled
                        dense
                        placeholder="Attitude 0-5"
                        color="success"
                        label="Attitude 0-5"
                        clearable
                        type="number"
                        hide-details="auto"
                        :rules="NumberField"
                        step="any"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="justify-end">
                <v-col cols="12" md="3">
                    <v-btn
                        :disabled="!valid"
                        variant="tonal"
                        type="submit"
                        color="success"
                        class="w-100"
                        ><v-icon>mdi-plus</v-icon> Add</v-btn
                    >
                </v-col>
            </v-row>
        </v-form>
        <v-data-table
            :headers="headers"
            :items="yearlyIPCR"
            :search="search"
            :loading="loading"
        >
            <template v-slot:item.actions="{ item }">
                <v-btn
                    color="error"
                    small
                    outlined
                    title="Delete"
                    @click="deleteRating(item.id)"
                >
                    <i class="fa-solid fa-trash me-1"></i>Delete
                </v-btn>
            </template>
        </v-data-table>
    </v-app>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            Years: [],
            yearlyIPCR: [],
            departmentItems: [],
            valid: false,
            loading: false,
            form: {
                year: null,
                dep_id: null,
                add_points: null,
                average: null,
            },
            FieldRequired: [(v) => !!v || "This field is required"],
            NumberField: [
                (v) => !!v || "This field is required",
                (v) => (v >= 0 && v <= 5) || "0 to 5 is valid",
            ],
            headers: [
                { text: "Department", value: "dep_name" },
                { text: "Year", value: "year" },
                { text: "Rating", value: "rating" },
                { text: "Actions", value: "actions", align: "center" },
            ],
        };
    },
    methods: {
        async getDepartment() {
            await axios
                .get("/api/getDepartmentIPCR/" + this.form.year)
                .then((response) => {
                    let Items = [];
                    response.data.map(function (value, key) {
                        Items.push({ id: value.id, name: value.name });
                    });
                    this.departmentItems = Items;
                });
        },
        async getYearsIPCR() {
            await axios.get("/api/getYearsIPCR2").then((response) => {
                let Items = [];
                response.data.map(function (value) {
                    Items.push(value);
                });
                this.Years = Items;
            });
        },
        async getAverage() {
            await axios
                .get("/api/getAverage/" + this.form.dep_id.id)
                .then((response) => {
                    Vue.set(this.form, "average", response.data);
                });
        },
        async addYearlyRating() {
            await axios
                .post("/HumanResource/yearlyIPCR", this.form)
                .then((response) => {
                    this.form.dep_id = null;
                    this.form.year = null;
                    this.form.add_points = null;
                    this.$refs.formValid.resetValidation();
                    this.getYearlyRating();
                    this.average = null;
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Rating Has been Added!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async deleteRating(id) {
            const answer = window.confirm(
                "Do you really want to Delete this Rating?"
            );
            if (answer) {
                await axios
                    .post("/HumanResource/yearlyIPCR/" + id, {
                        _method: "DELETE",
                    })
                    .then((response) => {
                        this.getYearlyRating();
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Rating Has been Delete!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
                        }
                    });
            }
        },
        async getYearlyRating() {
            this.loading = true;
            await axios.get("/api/getYearlyRating").then((response) => {
                this.yearlyIPCR = response.data;
                this.loading = false;
            });
        },
    },
    created() {
        this.getYearsIPCR();
        this.getYearlyRating();
    },
};
</script>
