<template>
    <div>
        <v-dialog
            v-model="show_modal"
            transition="dialog-top-transition"
            persistent
            max-width="1800"
        >
            <v-card>
                <v-toolbar color="success" dark>
                    <v-spacer>
                        <slot name="header" />
                    </v-spacer>
                    <v-btn text @click="close()">Close</v-btn>
                </v-toolbar>
                <v-card-text>
                    <slot name="content" />
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: {
        show_modal: Boolean,
        modal_color: String,
    },
    data() {
        return {};
    },
    methods: {
        close() {
            this.$emit("close");
        },
    },
};
</script>
