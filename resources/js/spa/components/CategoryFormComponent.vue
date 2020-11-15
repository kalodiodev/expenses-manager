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
                                v-model="editedItem.name"
                                :error-messages="nameErrors"
                                @blur="validateName"
                                label="Category Name"></v-text-field>
                        </v-col>
                        <v-col>
                            <v-color-picker
                                dot-size="25"
                                hide-inputs
                                hide-mode-switch
                                swatches-max-height="200"
                                v-model="editedItem.color"
                            ></v-color-picker>
                        </v-col>
                        <v-col>
                            <v-textarea
                                v-model="editedItem.description"
                                @blur="validateDescription"
                                :error-messages="descriptionErrors"
                                label="Description"></v-textarea>
                        </v-col>
                    </v-col>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close" :disabled="! buttonsEnabled">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save" :disabled="! buttonsEnabled">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import required from "vuelidate/lib/validators/required";
import maxLength from "vuelidate/lib/validators/maxLength";

export default {
    props: {
        existsUrl: {
            required: true,
            type: String
        },
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
    data() {
        return {
            nameErrors: [],
            descriptionErrors: [],
            buttonsEnabled: true
        }
    },
    validations: {
        editedItem: {
            name: {
                required: required,
                maxLength: maxLength(55),
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
            this.nameErrors = [];
            this.descriptionErrors = [];
            this.$emit('close-dialog');
        },
        save() {
            this.$v.editedItem.$touch();

            if (this.$v.editedItem.$invalid) return;

            this.$v.$reset();

            this.buttonsEnabled = false

            axios.post(this.existsUrl, {
                'name': this.editedItem.name
            }).then(res => {
                this.buttonsEnabled = true;
                if (res.data.exists && res.data.id !== this.editedItem.id) {
                    this.nameErrors.push('Name must be unique.')

                    return;
                }

                this.$emit('save-dialog', this.editedItem);
            });
        },
        validateName() {
            this.$v.editedItem.name.$touch();
            this.nameErrors = [];
            if (!this.$v.editedItem.name.$dirty) this.nameErrors = []
            !this.$v.editedItem.name.maxLength && this.nameErrors.push('Name must be at most 55 characters long')
            !this.$v.editedItem.name.required && this.nameErrors.push('Name is required.')
        },
        validateDescription() {
            this.$v.editedItem.description.$touch();
            this.descriptionErrors = []
            if (!this.$v.editedItem.description.$dirty) this.descriptionErrors = []
            !this.$v.editedItem.description.maxLength && this.descriptionErrors.push('Description must be at most 190 characters long')
        }
    }
}
</script>
