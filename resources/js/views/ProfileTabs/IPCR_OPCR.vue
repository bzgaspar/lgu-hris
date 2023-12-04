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
};
</script>

<style lang="scss" scoped></style>
