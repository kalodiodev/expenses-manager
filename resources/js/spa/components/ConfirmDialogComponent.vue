<template>
    <v-dialog v-model="dialog" persistent @update:return-value="cancel" max-width="600px">
        <v-card>
            <v-card-title>{{ title }}</v-card-title>
            <v-card-text>{{ message }}</v-card-text>

            <v-card-actions>
                <v-btn color="success" text class="mr-4" @click="accept">{{ confirmBtn }}</v-btn>
                <v-btn color="error" text @click="cancel">{{ rejectBtn }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                resolve: null,
                reject: null,
                title: 'Confirm',
                message: 'Are you sure',
                confirmBtn: 'Confirm',
                rejectBtn: 'Cancel'
            }
        },
        methods: {
            open(properties = {}) {
                this.dialog = true;

                if (properties.message) {
                    this.message = properties.message
                }

                if (properties.title) {
                    this.title = properties.title
                }

                if (properties.confirmText) {
                    this.confirmBtn = properties.confirmText
                }

                if (properties.rejectText) {
                    this.rejectBtn = properties.rejectText
                }

                return new Promise((resolve, reject) => {
                    this.resolve = resolve;
                    this.reject = reject;
                });
            },
            accept() {
                this.resolve(true);
                this.dialog = false;
            },
            cancel() {
                this.resolve(false);
                this.dialog = false;
            }
        }
    }
</script>
