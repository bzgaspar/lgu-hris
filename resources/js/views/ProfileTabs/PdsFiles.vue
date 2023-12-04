<template>
    <v-app>
        {{ user_role }}
    </v-app>
</template>

<script>
export default {
    props: ["user_id", "user_role"],
};
</script>

<style lang="scss" scoped></style>
