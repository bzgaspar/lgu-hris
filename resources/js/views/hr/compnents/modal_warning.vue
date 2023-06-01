<template>
    <div>
        <v-dialog
            v-model="show_modal"
            transition="dialog-top-transition"
            persistent
            max-width="400"
        >
            <v-card>
                <v-toolbar color="orange" dark>
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
        return {
        };
    },
    methods: {
        close() {
            this.$emit('update:show_modal', false)
        },
    },
};
</script>
