<template>
    <v-app class="bg-transparent mt-5" v-model="show_modal">
        <v-form ref="form">
            <v-container class="sm:w-100 md:w-50">
                <table class="table mb-4 sm:fs-6 md:fs-1">
                    <tr class="text-center">
                        <th colspan="2" class="table-bordered">
                            Vacation Leave
                        </th>
                        <th colspan="2">Sick Leave</th>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr class="pt-12">
                        <td>
                            <v-text-field
                                label="Previous Balance"
                                dense
                                v-model="old_elc_vl_balance"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                label="Earned Leave"
                                dense
                                v-model="edit_form.elc_vl_earned"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                label="Previous Balance"
                                dense
                                v-model="old_elc_sl_balance"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                label="Earned Leave"
                                dense
                                v-model="edit_form.elc_sl_earned"
                            >
                            </v-text-field>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <v-text-field
                                label="Deductions"
                                dense
                                v-model="vl_deductions"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                dense
                                label="New Balance"
                                v-model="edit_form.elc_vl_balance"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                label="Deductions"
                                dense
                                v-model="sl_deductions"
                            >
                            </v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                label="New Balance"
                                dense
                                v-model="edit_form.elc_sl_balance"
                            >
                            </v-text-field>
                        </td>
                    </tr>
                </table>
            </v-container>
            <v-row>
                <v-col class="pa-0" cols="12" sm="3" md="4">
                    <h4 class="text-lead m-2">Period</h4>
                    <v-row>
                        <v-col cols="12" sm="12" md="6">
                            <v-menu
                                ref="from_menu"
                                v-model="from_menu"
                                :close-on-content-click="false"
                                :return-value.sync="elc_period_from"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        color="success"
                                        dense
                                        small
                                        v-model="elc_period_from"
                                        label="From"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="elc_period_from"
                                    type="date"
                                    no-title
                                    scrollable
                                    color="success"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="success"
                                        @click="from_menu = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="success"
                                        @click="
                                            $refs.from_menu.save(
                                                elc_period_from
                                            )
                                        "
                                    >
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-menu
                                ref="to_menu"
                                v-model="to_menu"
                                :close-on-content-click="false"
                                :return-value.sync="elc_period_to"
                                transition="To"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        color="success"
                                        dense
                                        v-model="elc_period_to"
                                        label="Picker in menu"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="elc_period_to"
                                    type="date"
                                    no-title
                                    scrollable
                                    color="success"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="success"
                                        @click="to_menu = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="success"
                                        @click="
                                            $refs.to_menu.save(elc_period_to)
                                        "
                                    >
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <p class="text-danger">{{ dateMessage }}</p>
                </v-col>
                <v-col class="pa-2" cols="12" sm="9" md="8">
                    <h4 class="text-lead m-2">Vacation Leave</h4>
                    <v-row class="pa-2">
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-radio-group
                                class="pa-0 m-0"
                                row
                                v-model="vl_select"
                            >
                                <v-radio
                                    label="With Pay"
                                    value="0"
                                    color="success"
                                ></v-radio>
                                <v-radio
                                    label="Without Pay"
                                    value="1"
                                    color="success"
                                ></v-radio>
                            </v-radio-group>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="vl_minutes"
                                color="success"
                                dense
                                label="(Minutes)"
                                :items="minutes_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="vl_hour"
                                color="success"
                                dense
                                label="(Hour)"
                                :items="hour_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="vl_day"
                                color="success"
                                dense
                                label="(Day)"
                                :items="day_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-row class="pa-0">
                <v-col class="pa-2" cols="12" sm="3" md="4">
                    <h4 class="text-lead m-2">Other</h4>
                    <v-row>
                        <v-col class="pa-2" cols="12" sm="12" md="6">
                            <v-text-field
                                v-model="edit_form.elc_particular"
                                dense
                                color="success"
                                label="Particulars"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="12" md="6">
                            <v-text-field
                                v-model="edit_form.elc_remarks"
                                dense
                                color="success"
                                label="Remarks"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col class="pa-2" cols="12" sm="9" md="8">
                    <h4 class="text-lead m-0">Sick Leave</h4>
                    <v-row>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-radio-group class="pa-0" row v-model="sl_select">
                                <v-radio
                                    label="With Pay"
                                    color="success"
                                    value="0"
                                ></v-radio>
                                <v-radio
                                    label="Without Pay"
                                    color="success"
                                    value="1"
                                ></v-radio>
                            </v-radio-group>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="sl_minutes"
                                color="success"
                                dense
                                label="(Minutes)"
                                :items="minutes_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="sl_hour"
                                color="success"
                                dense
                                label="(Hour)"
                                :items="hour_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col class="pa-2" cols="12" sm="6" md="3">
                            <v-combobox
                                v-model="sl_day"
                                color="success"
                                dense
                                label="(Day)"
                                :items="day_items"
                                item-value="value"
                                item-text="id"
                            >
                            </v-combobox>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-container class="text-end mb-4">
                <v-btn color="secondary" class="w-25" @click="cancelEdit"
                    ><i class="fa-solid fa-x me-1"></i> Cancel</v-btn
                >
                <v-btn color="success" class="w-25" @click="UpdateLeaveCredit"
                    ><i class="fa-solid fa-check me-1"></i> Save</v-btn
                >
            </v-container>
        </v-form>
    </v-app>
</template>
<script>
import moment from "moment";

export default {
    props: {
        edit_leave: null,
        show_modal: Boolean,
    },
    data: () => ({
        to_menu: false,
        from_menu: false,
        hour_items: [],
        minutes_items: [],
        day_items: [],
        points_earn: {},
        prev_leave: [],
        earn_rate: [],
        elc_period_from: null,
        elc_period_to: null,
        old_elc_vl_balance: null,
        old_elc_sl_balance: null,
        vl_minutes: null,
        vl_hour: null,
        vl_day: null,
        sl_minutes: null,
        sl_hour: null,
        sl_day: null,
        elc_particular: null,
        elc_remarks: null,
        dateMessage: null,
        vl_select: "0",
        sl_select: "0",
        vl_deductions: 0,
        sl_deductions: 0,
        edit_form: {},
    }),
    methods: {
        async getMinute() {
            await axios.get("/api/getMinute").then((response) => {
                let Items = [];
                Items.push({ id: 0, value: 0 });
                response.data.map(function (value, key) {
                    Items.push({ id: value.id, value: value.value });
                });
                this.minutes_items = Items;
            });
        },
        async getHour() {
            await axios.get("/api/getHour").then((response) => {
                let Items = [];
                Items.push({ id: 0, value: 0 });
                response.data.map(function (value, key) {
                    Items.push({ id: value.id, value: value.value });
                });
                this.hour_items = Items;
            });
        },
        async getEarn() {
            await axios.get("/api/getEarn").then((response) => {
                this.earn_rate = response.data;
            });
        },
        CheckEarned() {
            if (this.elc_period_from && this.elc_period_to) {
                let month = moment(this.elc_period_from, "YYYY-MM-DD").format(
                    "MM"
                );
                const diffInDays =
                    moment(this.elc_period_to).diff(
                        moment(this.elc_period_from),
                        "days"
                    ) + 1;
                let earned = null;
                if (month == "02" && diffInDays >= 28) {
                    earned = 1.25;
                } else if (diffInDays >= 30) {
                    earned = 1.25;
                } else {
                    earned = this.earn_rate.filter(
                        (item) => item.id == diffInDays
                    );
                    earned = earned[0].value;
                }

                Vue.set(this.edit_form, "elc_vl_earned", earned);
                Vue.set(this.edit_form, "elc_sl_earned", earned);

                let elc_vl_balance =
                    this.old_elc_vl_balance +
                    this.edit_form.elc_vl_earned -
                    this.vl_deductions;
                let elc_sl_balance =
                    this.old_elc_sl_balance +
                    this.edit_form.elc_sl_earned -
                    this.sl_deductions;
                Vue.set(this.edit_form, "elc_sl_balance", elc_sl_balance);
                Vue.set(this.edit_form, "elc_vl_balance", elc_vl_balance);
            }
        },
        checkDeductions() {
            const vl_deductions = [];
            const sl_deductions = [];
            this.vl_minutes ? vl_deductions.push(this.vl_minutes.value) : "";
            this.vl_hour ? vl_deductions.push(this.vl_hour.value) : "";
            this.vl_day ? vl_deductions.push(this.vl_day) : "";

            this.sl_minutes ? sl_deductions.push(this.sl_minutes.value) : "";
            this.sl_hour ? sl_deductions.push(this.sl_hour.value) : "";
            this.sl_day ? sl_deductions.push(this.sl_day) : "";

            this.vl_deductions = vl_deductions.reduce(
                (acc, val) => acc + val,
                0
            );
            this.sl_deductions = sl_deductions.reduce(
                (acc, val) => acc + val,
                0
            );
            let elc_vl_balance =
                this.old_elc_vl_balance +
                this.edit_form.elc_vl_earned -
                this.vl_deductions;
            let elc_sl_balance =
                this.old_elc_sl_balance +
                this.edit_form.elc_sl_earned -
                this.sl_deductions;

            Vue.set(this.edit_form, "elc_sl_balance", elc_sl_balance);
            Vue.set(this.edit_form, "elc_vl_balance", elc_vl_balance);
        },
        cancelEdit() {
            this.$emit("close");
        },
        getPreviousLeave(user_id) {
            axios
                .get(
                    "/api/getPreviousLeave/" +
                        user_id +
                        "/" +
                        this.edit_leave.id
                )
                .then((response) => {
                    this.prev_leave = response.data;
                    this.old_elc_vl_balance = this.prev_leave.elc_vl_balance;
                    this.old_elc_sl_balance = this.prev_leave.elc_sl_balance;
                    this.edit_form = this.edit_leave;
                    if (this.edit_form.elc_vl_auw_p) {
                        this.vl_deductions = this.edit_form.elc_vl_auw_p;
                    } else if (this.edit_form.elc_vl_auw_po) {
                        this.vl_deductions = this.edit_form.elc_vl_auw_po;
                    }
                    if (this.edit_form.elc_sl_auw_p) {
                        this.sl_deductions = this.edit_form.elc_sl_auw_p;
                    } else if (this.edit_form.elc_sl_auw_po) {
                        this.sl_deductions = this.edit_form.elc_sl_auw_po;
                    }

                    this.elc_period_from = this.edit_leave.elc_period_from;
                    this.elc_period_to = this.edit_leave.elc_period_to;
                });
        },
        async UpdateLeaveCredit() {
            if (this.elc_period_to == this.elc_period_from) {
                this.dateMessage = "The Period Should not be the same today!";
                if (this.$root.vtoast) {
                    this.$root.vtoast.show({
                        message: this.dateMessage,
                        color: "error",
                        icon: "mdi-check",
                    });
                }
            } else {
                this.edit_form.elc_period_from = this.elc_period_from;
                this.edit_form.elc_period_to = this.elc_period_to;

                if (this.vl_select == 0) {
                    this.edit_form.elc_vl_auw_p = this.vl_deductions;
                    this.edit_form.elc_vl_auwo_p = 0;
                } else {
                    this.edit_form.elc_vl_auwo_p = this.vl_deductions;
                    this.edit_form.elc_vl_auw_p = 0;
                }
                if (this.sl_select == 0) {
                    this.edit_form.elc_sl_auw_p = this.sl_deductions;
                    this.edit_form.elc_sl_auwo_p = 0;
                } else {
                    this.edit_form.elc_sl_auwo_p = this.sl_deductions;
                    this.edit_form.elc_sl_auw_p = 0;
                }

                await axios
                    .post(
                        "/HumanResource/leave/" + this.edit_form.id,
                        this.edit_form,
                        {
                            headers: {
                                "X-HTTP-Method-Override": "PATCH",
                            },
                        }
                    )
                    .then((response) => {
                        this.$emit("close");

                        if (this.$root.vtoast) {
                            this.$root.vtoast.show({
                                message: "Leave Credit Updated!",
                                color: "success",
                                icon: "mdi-exclamation",
                            });
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
    },
    filter: {
        roundTwoDecimals: function (value) {
            if (!value) return "";
            return Math.round(value * 100) / 100;
        },
    },
    watch: {
        elc_period_from() {
            this.CheckEarned();
        },
        elc_period_to() {
            this.CheckEarned();
        },
        vl_minutes() {
            this.checkDeductions();
        },
        vl_hour() {
            this.checkDeductions();
        },
        vl_day() {
            this.checkDeductions();
        },
        sl_minutes() {
            this.checkDeductions();
        },
        sl_hour() {
            this.checkDeductions();
        },
        sl_day() {
            this.checkDeductions();
        },
    },
    created() {
        // this.getMinute();
        // this.getHour();
        // this.getPreviousLeave(this.edit_leave.user_id);
        // this.getEarn();
        // let Items = [];
        // for (let i = 0; i < 31; i++) {
        //     Items.push(i + 1);
        // }
        // this.day_items = Items;
        // this.edit_form.user_id = this.leave_card_id;
    },
    mounted() {
        this.getMinute();
        this.getHour();
        this.getPreviousLeave(this.edit_leave.user_id);
        this.getEarn();
        let Items = [];
        for (let i = 0; i < 31; i++) {
            Items.push(i + 1);
        }
        this.day_items = Items;
    },
};
</script>
