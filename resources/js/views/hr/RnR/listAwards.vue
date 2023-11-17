<template>
    <v-app class="bg-transparent mt-5">
        <v-form
            @submit.prevent="submitForm"
            ref="form"
            enctype="multipart/form-data"
        >
            <v-row justify-center>
                <v-col xs="12" class="text-center">
                    <label for="User">User</label>
                    <v-combobox
                        :items="employees"
                        v-model="form.user_id"
                        item-value="id"
                        item-text="name"
                        label="User"
                        hide-details
                        placeholder="User"
                        solo
                        dense
                    ></v-combobox>
                </v-col>
                <v-col xs="12" class="text-center">
                    <label for="Date">Date</label>
                    <v-text-field
                        v-model="form.date"
                        label="Date"
                        type="date"
                        placeholder="Date"
                        single-line
                        hide-details
                        solo
                        dense
                    ></v-text-field>
                </v-col>
                <v-col xs="12" class="text-center">
                    <label for="File">File</label>
                    <v-file-input
                        v-model="form.document"
                        label="File"
                        type="file"
                        placeholder="File"
                        single-line
                        hide-details
                        accept=".pdf"
                        solo
                        dense
                    ></v-file-input>
                </v-col>
            </v-row>
            <v-row class="justify-center mb-4">
                <v-col>
                    <label for="Title">Title</label>
                    <v-textarea
                        v-model="form.title"
                        hide-details
                        solo
                        dense
                        label="Title"
                        placeholder="Title"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-btn
                :disabled="!validBTN"
                type="submit"
                class="w-100"
                color="success"
                >Save</v-btn
            >
        </v-form>
        <v-container>
            <v-data-table
                :headers="headers"
                :items="listOfAwards"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        v-if="item.document"
                        @click="viewDocument(item.document)"
                        color="success"
                        small
                        outlined
                        title="View"
                    >
                        <i class="fa-solid fa-eye me-1"></i>View
                    </v-btn>
                    <v-btn
                        @click="editList(item)"
                        color="orange"
                        small
                        outlined
                        title="Edit"
                    >
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                    </v-btn>
                    <v-btn
                        @click="deleteList(item.id)"
                        color="error"
                        small
                        outlined
                        title="Delete"
                    >
                        <i class="fa-solid fa-trash me-1"></i> Delete
                    </v-btn>
                </template>
            </v-data-table>
        </v-container>
        <v-dialog persistent v-model="showEdit" width="500">
            <v-card>
                <v-form
                    @submit.prevent="submitEditForm()"
                    ref="form"
                    enctype="multipart/form-data"
                >
                    <v-card-title class="text-h5 success text-white">
                        <i class="fa-solid fa-award me-1"></i>Edit Award
                    </v-card-title>

                    <v-card-text class="py-5">
                        <v-row justify-center>
                            <v-col xs="12" class="text-center">
                                <label for="Date">Date</label>
                                <v-text-field
                                    v-model="form2.date"
                                    label="Date"
                                    type="date"
                                    placeholder="Date"
                                    single-line
                                    hide-details
                                    solo
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col xs="12" class="text-center">
                                <label for="File">File</label>
                                <v-file-input
                                    v-model="form2.document"
                                    label="File"
                                    type="file"
                                    placeholder="File"
                                    single-line
                                    hide-details
                                    accept=".pdf"
                                    solo
                                    dense
                                ></v-file-input>
                            </v-col>
                        </v-row>
                        <v-row class="justify-center mb-4">
                            <v-col>
                                <label for="Title">Title</label>
                                <v-textarea
                                    v-model="form2.title"
                                    hide-details
                                    solo
                                    dense
                                    label="Title"
                                    placeholder="Title"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="error" @click="showEdit = false">
                            Cancel
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                            :disabled="!validBTN2"
                            type="submit"
                            color="success"
                            >Save</v-btn
                        >
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            showEdit: false,
            validBTN: false,
            validBTN2: false,
            title: "",
            edit_id: null,
            form: {},
            form2: {},
            employees: [],
            search: "",
            loading: false,
            listOfAwards: [],
            headers: [
                {
                    text: "ID",
                    align: "start",
                    sortable: true,
                    value: "id",
                    align: " d-none",
                },
                { text: "Name", align: "center", value: "name" },
                { text: "Title", align: "center", value: "title" },
                { text: "Actions", align: "center", value: "actions" },
            ],
        };
    },
    methods: {
        getListOfAwards() {
            setTimeout(async () => {
                this.loading = true;
                await axios.get("/api/getListOfAwards").then((response) => {
                    this.listOfAwards = response.data;
                    this.loading = false;
                });
            }, 1000);
        },
        getEmployee() {
            setTimeout(async () => {
                await axios.get("/api/getEmployee").then((response) => {
                    let data = response.data;
                    let emp = [];
                    if (data) {
                        data.map(function (item) {
                            emp.push({ id: item.user_id, name: item.name });
                        });
                    }
                    this.employees = emp;
                });
            }, 1000);
        },
        async submitForm() {
            // console.log(this.form);
            let formData = new FormData();
            formData.append("user_id", this.form.user_id["id"]);
            if (this.form.document) {
                formData.append("document", this.form.document);
            }
            formData.append("title", this.form.title);
            formData.append("date", this.form.date);
            await axios
                .post("/HumanResource/listAwards", formData)
                .then((response) => {
                    if (this.$root.vtoast) {
                        this.form = [];
                        this.validBTN = false;
                        this.$root.vtoast.show({
                            message: "Record is Added!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                        this.getListOfAwards();
                    }
                })
                .catch((errors) => {
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: errors.error.message,
                            color: "error",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async submitEditForm() {
            // console.log(this.form);
            let formData = new FormData();
            if (this.form2.document) {
                formData.append("document", this.form2.document);
            }
            formData.append("title", this.form2.title);
            formData.append("date", this.form2.date);
            formData.append("user_id", this.form2.user_id);
            formData.append("_method", "PATCH");
            await axios
                .post("/HumanResource/listAwards/" + this.edit_id, formData)
                .then((response) => {
                    this.showEdit = false;
                    if (this.$root.vtoast) {
                        this.form = [];
                        this.validBTN = false;
                        this.$root.vtoast.show({
                            message: "Record is Added!",
                            color: "success",
                            icon: "mdi-exclamation",
                        });
                        this.getListOfAwards();
                    }
                })
                .catch((errors) => {
                    if (this.$root.vtoast) {
                        this.$root.vtoast.show({
                            message: errors.error.message,
                            color: "error",
                            icon: "mdi-exclamation",
                        });
                    }
                });
        },
        async deleteList(id) {
            if (confirm("Are you sure you want to delete this?")) {
                await axios
                    .post("/HumanResource/listAwards/" + id, {
                        _method: "DELETE",
                    })
                    .then((response) => {
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Record is Deleted!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
                            this.getListOfAwards();
                        }
                    })
                    .catch((errors) => {
                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: errors.error.message,
                                color: "error",
                                icon: "mdi-exclamation",
                            });
                        }
                    });
            }
        },
        viewDocument(document) {
            window.open(
                "/storage/listAwards/" + document,
                "_blank",
                "noreferrer"
            );
        },
        editList(listItem) {
            this.showEdit = true;
            this.edit_id = listItem.id;
            this.form2.title = listItem.title;
            this.form2.date = listItem.date;
            this.form2.user_id = listItem.user_id;
            this.validBTN2 = true;
        },
    },
    watch: {
        form(value) {
            if (value.user_id && value.title && value.date) {
                this.validBTN = true;
            } else {
                this.validBTN = false;
            }
        },
        form2(value) {
            console.log(value);
            // if (value.title && value.date) {
            //     this.validBTN2 = true;
            // } else {
            //     this.validBTN2 = false;
            // }
        },
    },
    created() {
        this.getEmployee();
        this.getListOfAwards();
    },
};
</script>
