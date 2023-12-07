<template>
    <v-app>
        <div v-if="user_role === 3 || user_role === 7">
            <OPCR :user_id="user_id" />
        </div>
        <div v-else><IPCR :user_id="user_id" /></div>
    </v-app>
</template>

<script>
import IPCR from "./ipcr/table.vue";
import OPCR from "./ipcr/table2.vue";
export default {
    props: ["user_id", "user_role"],
    components: {
        IPCR,
        OPCR,
    },
    data() {
        return {
            chartData: {
                2020: ["4.8"],
                2021: ["4.9"],
                2022: ["4.4"],
                2023: ["4.88"],
                2024: ["4.7"],
                2025: ["4.6"],
            },
            chartOptions: {
                scales: {
                    x: {
                        type: "linear",
                        position: "bottom",
                    },
                    y: {
                        min: 0,
                    },
                },
            },
        };
    },
};
</script>

<style lang="scss" scoped></style>
