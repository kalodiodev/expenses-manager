<template>
    <v-dialog :value="dialog" max-width="500px" persistent>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" @click="newDialog">{{ newBtn }}</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-col>
                        <v-col>
                            <v-text-field
                                v-model="$v.editedItem.name.$model"
                                :error-messages="nameErrors"
                                label="Category Name"></v-text-field>
                        </v-col>
                        <v-col>
                            <v-textarea
                                v-model="$v.editedItem.description.$model"
                                :error-messages="descriptionErrors"
                                label="Description"></v-textarea>
                        </v-col>
                    </v-col>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save" :disabled="$v.editedItem.$invalid">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import required from "vuelidate/lib/validators/required";
import maxLength from "vuelidate/lib/validators/maxLength";

export default {
    props: {
        dialog: {
            default: false,
            type: Boolean
        },
        title: {
            type: String
        },
        newBtn: {
            type: String
        },
        editedItem: {
            type: Object
        }
    },
    validations: {
        editedItem: {
            name: {
                required: required,
                maxLength: maxLength(55)
            },
            description: {
                maxLength: maxLength(190)
            }
        }
    },
    methods: {
        newDialog() {
            this.$emit('new-dialog');
        },
        close() {
            this.$v.$reset();
            this.$emit('close-dialog');
        },
        save() {
            if (this.$v.editedItem.$invalid) {
                console.log('Validation');

                return;
            }

            this.$emit('save-dialog', this.editedItem);
        },
    },
    computed: {
        nameErrors () {
            const errors = []
            if (!this.$v.editedItem.name.$dirty) return errors
            !this.$v.editedItem.name.maxLength && errors.push('Name must be at most 55 characters long')
            !this.$v.editedItem.name.required && errors.push('Name is required.')
            return errors
        },
        descriptionErrors () {
            const errors = []
            if (!this.$v.editedItem.description.$dirty) return errors
            !this.$v.editedItem.description.maxLength && errors.push('Description must be at most 190 characters long')
            return errors
        }
    }
}
</script>
