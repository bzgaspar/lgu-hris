<template>
    <v-row>
        <v-col>
            <p>MFO Questions</p>
            <v-form @submit.prevent="addMFO" v-model="valid">
                <v-textarea
                    solo
                    v-model="form.question"
                    label="Question"
                    name="question"
                    placeholder="Question"
                    :rules="FieldRequired"
                ></v-textarea>
                <v-combobox
                    v-model="form.type"
                    solo
                    :items="MFO_types"
                    label="Type (Can manually type here)"
                    name="type"
                    placeholder="Type (Can manually type here)"
                    :rules="FieldRequired"
                ></v-combobox>
                <v-select
                    v-model="form.dep_id"
                    solo
                    :items="departments"
                    item-text="name"
                    item-value="id"
                    label="Department"
                    placeholder="Department"
                    :rules="FieldRequired"
                ></v-select>
                <v-btn
                    :disabled="!valid"
                    type="submit"
                    class="w-100 bg-success text-white"
                    ><i class="fa-solid fa-plus me-1"></i>Add</v-btn
                >
            </v-form>

            <v-data-table
                :headers="headers"
                :items="MFO_questions"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deleteMfoQuestion(item.id)"
                    >
                        <i class="fa-solid fa-trash me-1"></i>Delete
                    </v-btn>
                </template>
            </v-data-table>
        </v-col>
        <v-col>
            <p>Indicators</p>
            <v-form @submit.prevent="addIndicators" v-model="valid2">
                <v-textarea
                    solo
                    v-model="form2.question"
                    label="Question"
                    name="question"
                    placeholder="Question"
                    :rules="FieldRequired"
                ></v-textarea>
                <v-select
                    v-model="form2.dep_id"
                    solo
                    :items="departments"
                    item-text="name"
                    item-value="id"
                    label="Department"
                    placeholder="Department"
                    :rules="FieldRequired"
                ></v-select>
                <v-btn
                    :disabled="!valid2"
                    type="submit"
                    class="w-100 bg-success text-white"
                    ><i class="fa-solid fa-plus me-1"></i>Add</v-btn
                >
            </v-form>

            <v-data-table
                :headers="headers2"
                :items="questions"
                :loading="loading2"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="error"
                        small
                        outlined
                        title="Delete"
                        @click="deleteQuestion(item.id)"
                    >
                        <i class="fa-solid fa-trash me-1"></i>Delete
                    </v-btn>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            headers: [
                { text: "Question", value: "question" },
                { text: "Type", value: "type" },
                { text: "Department", value: "name" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            headers2: [
                { text: "Question", value: "question" },
                { text: "Department", value: "name" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            form: {
                question: null,
                type: null,
            },
            form2: {
                question: null,
            },
            MFO_questions: [],
            questions: [],
            departments: [],
            MFO_types: [],
            valid: false,
            valid2: false,
            loading: false,
            loading2: false,
            FieldRequired: [(v) => !!v || "This field is required"],
            // MFO_types: [
            //     "Procurement",
            //     "Issuance of Supplies and Materials",
            //     "Inventory & Custodians of Public Properties",
            //     "Disposal of unserviceable Properties by the concerned Department/Offices",
            //     "Janitorial Services",
            //     "Archiving of PPE & Supplies Records Management",
            //     "Issuance of Documents as per request of concerned Departments",
            //     "GAS (General Administrative Services)",
            //     "HUMAN RESOUCE MANAGEMENT PROGRAM",
            //     "PHILIPPINE CIVIL SERVICE MONTH",
            //     "ADMINISTRATIVE SERVICES",
            //     "PRIME HRM COMPLIANCE",
            //     "INFORMATION AND RECORDS MANAGEMENT",
            //     "CERTIFICATIONS",
            //     "HUMAN RESOURCE AUDIT",
            //     "SUBMISSION OF REPORTS ",
            //     "INFORMATION & COMMUNICATION TECHNOLOGY",
            // ],
        };
    },
    methods: {
        async addMFO() {
            await axios
                .post("/HumanResource/MFO_Questions", this.form)
                .then((response) => {
                    this.form.question = null;
                    this.form.type = null;
                    this.form.dep_id = null;
                    this.getMFOQuestions();
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Question Has been Added!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async getMFOQuestions() {
            this.loading = true;
            await axios.get("/api/getMFOQuestions").then((response) => {
                this.MFO_questions = response.data;
                this.loading = false;
                this.getMFOTypes();
            });
        },
        async getMFOTypes() {
            this.loading = true;
            await axios.get("/api/getMFOTypes").then((response) => {
                let arry = Object.keys(response.data).map(
                    (key) => response.data[key].type
                );
                this.MFO_types = arry;
            });
        },
        async getDepartment() {
            this.loading = true;
            await axios.get("/api/getDepartment").then((response) => {
                let dep = response.data;
                let data = [];
                dep.map(function (item) {
                    data.push({ id: item.id, name: item.name });
                });
                this.departments = data;
            });
        },
        async getQuestions() {
            this.loading = true;
            await axios.get("/api/getQuestions").then((response) => {
                this.questions = response.data;
                this.loading = false;
            });
        },
        async addIndicators() {
            await axios
                .post("/HumanResource/Indicators_questions", this.form2)
                .then((response) => {
                    this.form2.question = null;
                    this.form2.dep_id = null;
                    this.getQuestions();
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Question Has been Added!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async deleteMfoQuestion(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/HumanResource/MFO_Questions/" + id)
                    .then((resp) => {
                        this.getMFOQuestions();
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Question Has been Deleted!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
                        }
                    })
                    .catch((error) => {});
            }
        },
        async deleteQuestion(id) {
            if (confirm("Are you sure?")) {
                axios
                    .delete("/HumanResource/Indicators_questions/" + id)
                    .then((resp) => {
                        this.getQuestions();
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Question Has been Deleted!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
                        }
                    })
                    .catch((error) => {});
            }
        },
    },
    created() {
        this.getMFOTypes();
        this.getMFOQuestions();
        this.getQuestions();
        this.getDepartment();
    },
};
</script>
