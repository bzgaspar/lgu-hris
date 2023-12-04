<template>
    <v-app
        ><v-card>
            <v-tabs
                v-model="tab"
                background-color="success"
                centered
                dark
                icons-and-text
            >
                <v-tabs-slider></v-tabs-slider>

                <v-tab href="#tab-1"> PDS </v-tab>
                <v-tab href="#tab-2"> PDS Files </v-tab>
                <v-tab href="#tab-3"> 201 Files </v-tab>
                <v-tab href="#tab-4"> IPCR / OPCR </v-tab>
                <v-tab href="#tab-5"> Leave Credits </v-tab>
                <v-tab href="#tab-6"> Service Record </v-tab>
                <v-tab href="#tab-7"> Others </v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
                <v-tab-item value="tab-1">
                    <v-card flat>
                        <v-card-text>
                            <PDS />
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-2">
                    <v-card flat>
                        <v-card-text
                            ><PdsFiles :user_id="user_id"
                        /></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-3">
                    <v-card flat>
                        <v-card-text><Files :user_id="user_id" /></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-4">
                    <v-card flat>
                        <v-card-text
                            ><IPCR_OPCR
                                :user_role="user_role"
                                :user_id="user_id"
                        /></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-5">
                    <v-card flat>
                        <v-card-text
                            ><LeaveCredits :user_id="user_id"
                        /></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-6">
                    <v-card flat>
                        <v-card-text
                            ><ServiceRecord :user_id="user_id"
                        /></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item value="tab-7">
                    <v-card flat>
                        <v-card-text><Others /></v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
    </v-app>
</template>
<script>
import PDS from "../views/ProfileTabs/PDS.vue";
import Files from "../views/ProfileTabs/Files.vue";
import IPCR_OPCR from "../views/ProfileTabs/IPCR_OPCR.vue";
import LeaveCredits from "../views/ProfileTabs/LeaveCredits.vue";
import Others from "../views/ProfileTabs/Others.vue";
import ServiceRecord from "../views/ProfileTabs/ServiceRecord.vue";
import PdsFiles from "../views/ProfileTabs/PdsFiles.vue";
export default {
    components: {
        PDS,
        Files,
        IPCR_OPCR,
        LeaveCredits,
        Others,
        ServiceRecord,
        PdsFiles,
    },
    props: ["user_id", "user_role"],
    data() {
        return {
            tab: 123,
        };
    },
};
</script>
