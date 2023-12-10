<template>
    <v-app>
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
                <v-text-field
                    v-model="search1"
                    class="mt-4"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                    solo
                    dense
                ></v-text-field>
                <v-data-table
                    :headers="headers"
                    :items="MFO_questions"
                    :search="search1"
                    :loading="loading"
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            color="orange"
                            small
                            outlined
                            title="Delete"
                            @click="ShowEditMFO(item)"
                        >
                            <i class="fa-solid fa-pen me-1"></i>Edit
                        </v-btn>
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
                    <v-combobox
                        v-model="form2.type"
                        solo
                        :items="MFO_types"
                        label="Type (Can manually type here)"
                        name="type"
                        placeholder="Type (Can manually type here)"
                        :rules="FieldRequired"
                    ></v-combobox>
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

                <v-text-field
                    v-model="search2"
                    append-icon="mdi-magnify"
                    label="Search"
                    class="mt-4"
                    single-line
                    hide-details
                    solo
                    dense
                ></v-text-field>
                <v-data-table
                    :headers="headers2"
                    :items="questions"
                    :search="search2"
                    :loading="loading2"
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            color="orange"
                            small
                            outlined
                            title="Delete"
                            @click="ShowEdit(item)"
                        >
                            <i class="fa-solid fa-pen me-1"></i>Edit
                        </v-btn>
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
        <Modal
            :show_modal.sync="show_edit_question"
            @close="show_edit_question = !show_edit_question"
        >
            <template #header> Edit Indicators </template>
            <template #content>
                <v-form @submit.prevent="updateIndicators" v-model="valid3">
                    <v-textarea
                        solo
                        v-model="form3.question"
                        label="Question"
                        name="question"
                        placeholder="Question"
                        :rules="FieldRequired"
                    ></v-textarea>
                    <v-combobox
                        v-model="form3.type"
                        solo
                        :items="MFO_types"
                        label="Type (Can manually type here)"
                        name="type"
                        placeholder="Type (Can manually type here)"
                        :rules="FieldRequired"
                    ></v-combobox>
                    <v-btn
                        :disabled="!valid3"
                        type="submit"
                        color="success"
                        class="w-100"
                        small
                        outlined
                        title="Delete"
                        ><i class="fa-solid fa-check me-1"></i>Save</v-btn
                    >
                </v-form>
            </template>
        </Modal>
        <Modal
            :show_modal.sync="show_edit_mfo_question"
            @close="show_edit_mfo_question = !show_edit_mfo_question"
        >
            <template #header> Edit MFO Question</template>
            <template #content>
                <v-form @submit.prevent="updateMFO" v-model="valid4">
                    <v-textarea
                        solo
                        v-model="form4.question"
                        label="Question"
                        name="question"
                        placeholder="Question"
                        :rules="FieldRequired"
                    ></v-textarea>
                    <v-combobox
                        v-model="form4.type"
                        solo
                        :items="MFO_types"
                        label="Type (Can manually type here)"
                        name="type"
                        placeholder="Type (Can manually type here)"
                        :rules="FieldRequired"
                    ></v-combobox>
                    <v-btn
                        :disabled="!valid4"
                        type="submit"
                        color="success"
                        small
                        class="w-100"
                        outlined
                        title="Delete"
                        ><i class="fa-solid fa-check me-1"></i>Save</v-btn
                    >
                </v-form>
            </template>
        </Modal>
    </v-app>
</template>

<script>
import Modal from "../../compnents/modal.vue";
export default {
    components: {
        Modal,
    },
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
                { text: "Type", value: "type" },
                { text: "Department", value: "name" },
                { text: "Actions", value: "actions", align: "center" },
            ],
            form: {
                question: null,
                type: null,
            },
            form4: {
                question: null,
                type: null,
                _method: "PATCH",
            },
            form2: {
                question: null,
                type: null,
            },
            form3: {
                question: null,
                type: null,
                _method: "PATCH",
            },
            MFO_questions: [],
            questions: [],
            departments: [],
            MFO_types: [],
            show_edit_question: false,
            show_edit_mfo_question: false,
            edit_question: [],
            valid: false,
            valid2: false,
            search1: null,
            search2: null,
            valid3: false,
            valid4: false,
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
        async updateMFO() {
            await axios
                .post(
                    "/HumanResource/MFO_Questions/" + this.form4.id,
                    this.form4
                )
                .then((response) => {
                    this.form4.question = null;
                    this.form4.type = null;
                    this.form4.dep_id = null;
                    this.getMFOQuestions();
                    this.show_edit_mfo_question = !this.show_edit_mfo_question;
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Question Has been Updated!",
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
        async updateIndicators() {
            await axios
                .post(
                    "/HumanResource/Indicators_questions/" + this.form3.id,
                    this.form3
                )
                .then((response) => {
                    this.form3.question = null;
                    this.form3.dep_id = null;
                    this.getQuestions();
                    this.show_edit_question = !this.show_edit_question;
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: "Question Has been Updated!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async deleteMfoQuestion(id) {
            if (confirm("Are you sure?")) {
                axios
                    .post("/HumanResource/MFO_Questions/" + id, {
                        _method: "DELETE",
                    })
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
                    .post("/HumanResource/Indicators_questions/" + id, {
                        _method: "DELETE",
                    })
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
        async ShowEdit(item) {
            this.show_edit_question = !this.show_edit_question;
            this.form3.question = item.question;
            this.form3.type = item.type;
            this.form3.id = item.id;
        },
        async ShowEditMFO(item) {
            this.show_edit_mfo_question = !this.show_edit_mfo_question;
            this.form4.question = item.question;
            this.form4.type = item.type;
            this.form4.id = item.id;
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
