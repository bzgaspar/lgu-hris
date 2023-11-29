<template>
    <v-app>
        <div class="row mt-4 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Service Record</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <v-combobox
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        v-model="service_record"
                                        label="Select Employee"
                                        solo
                                        dense
                                        clearable
                                    >
                                    </v-combobox>
                                </div>
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    id="serviceRecord"
                                    class="btn btn-outline-success w-100"
                                    @click="viewServiceRecord()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Certificate of Employment</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <v-combobox
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        v-model="coe"
                                        label="Select Employee"
                                        solo
                                        dense
                                        clearable
                                    >
                                    </v-combobox>
                                </div>
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    id="coe"
                                    class="btn btn-outline-success w-100"
                                    @click="viewCOE()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Personal Data Sheet</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <v-combobox
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        v-model="pds"
                                        label="Select Employee"
                                        solo
                                        dense
                                        clearable
                                    >
                                    </v-combobox>
                                </div>
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    id="pds"
                                    class="btn btn-outline-success w-100"
                                    @click="viewPDS()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Leave Card</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <v-combobox
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        v-model="leave_card"
                                        label="Select Employee"
                                        solo
                                        dense
                                        clearable
                                    >
                                    </v-combobox>
                                </div>
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    id="leavecard"
                                    class="btn btn-outline-success w-100"
                                    @click="viewLeaveCard()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Publication</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <button
                                    type="button"
                                    id="pds"
                                    class="btn btn-outline-success w-100"
                                    @click="ViewPublication()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Employee Plantilla</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <button
                                    type="button"
                                    id="leavecard"
                                    class="btn btn-outline-success w-100"
                                    @click="ViewPlantilla()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Employee by Gender</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <v-combobox
                                        :items="['Male', 'Female']"
                                        v-model="gender"
                                        label="Select Gender"
                                        solo
                                        dense
                                        clearable
                                    >
                                    </v-combobox>
                                </div>
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    id="pds"
                                    class="btn btn-outline-success w-100"
                                    @click="ViewByGender()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Employee Plantilla</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <button
                                    type="button"
                                    id="leavecard"
                                    class="btn btn-outline-success w-100"
                                    @click="ViewPlantilla()"
                                >
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            users: [],
            service_record: "",
            coe: "",
            pds: "",
            leave_card: "",
            gender: "",
        };
    },
    methods: {
        async getUser() {
            await axios.get("/api/getAllUser").then((response) => {
                let Items = [];
                response.data.map(function (value, key) {
                    Items.push({ id: value.id, name: value.name });
                });
                this.users = response.data;
            });
        },
        viewServiceRecord() {
            window.open(
                "/HumanResource/service/" + this.service_record.id + "/edit",
                "_blank"
            );
        },
        viewCOE() {
            window.open("/HumanResource/dashboard/" + this.coe.id, "_blank");
        },
        viewPDS() {
            window.open("/users/pds/" + this.pds.id + "/print", "_blank");
        },
        viewLeaveCard() {
            window.open(
                "/HumanResource/leavecard/" + this.leave_card.id,
                "_blank"
            );
        },
        ViewPlantilla() {
            window.open("/HumanResource/plantilla/create", "_blank");
        },
        ViewPublication() {
            window.open("/HumanResource/publication/create", "_blank");
        },
        ViewByGender() {
            window.open("/HumanResource/employeesGender/" + this.gender, "_blank");
        },
    },

    created() {
        this.getUser();
    },
};
</script>
