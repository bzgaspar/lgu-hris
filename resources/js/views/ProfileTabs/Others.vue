<template>
    <v-app>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col>
                        <v-row>
                            <v-col>No. :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.plantilla.EPno
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Position :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.plantilla.EPposition
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Department :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.department.name
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Designation :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.designation.name
                            }}</v-col>
                        </v-row>
                    </v-col>
                    <v-col>
                        <v-row>
                            <v-col>Vacation Leave :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.latest_vl
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Sick Leave :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.latest_sl
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Terminal Leave Benefits :</v-col>
                            <v-col class="font-weight-bold">{{
                                otherInformation.tlb
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Next Loyalty Award :</v-col>
                            <v-col class="font-weight-bold">{{
                                formattedDate
                            }}</v-col>
                        </v-row>
                        <v-row>
                            <v-col>Current Salary:</v-col>
                            <v-col class="font-weight-bold">{{
                                formattedSalary
                            }}</v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script>
import moment from "moment";
export default {
    props: ["user_id", "user_role"],
    components: {
        moment,
    },
    data() {
        return {
            loading: false,
            otherInformation: [],
        };
    },
    methods: {
        loadTable() {
            setTimeout(() => {
                axios
                    .get("/api/getUserOtherInformation/" + this.user_id)
                    .then((response) => {
                        this.otherInformation = response.data;
                    });
            }, 1000);
        },
    },
    created() {
        this.loadTable();
    },
    computed: {
        formattedDate() {
            return moment(
                this.otherInformation.next_loyalty,
                "YYYY-MM-DD HH:mm:ss"
            ).format("DD-MM-YYYY");
        },
        formattedSalary() {
            const formattedNumber = Number(
                this.otherInformation.latest_salary
            ).toFixed(2);

            // Use regex to add commas as thousand separators
            return formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
};
</script>

<style lang="scss" scoped></style>
