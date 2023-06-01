<template>
        <app-vtoast ref="vtoast" />
</template>
<script>
import Vtoast from "./Alert.vue";
export default {
    components: {
        "app-vtoast": Vtoast,
    },
    mounted() {
        this.$root.vtoast = this.$refs.vtoast;
    },
};
</script>
