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
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save" :disabled="!isValid">Save</v-btn>
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
            validatedName: ''
        }
    },
    validations: {
        editedItem: {
            name: {
                required: required,
                maxLength: maxLength(55),
                isUnique: function (value) {
                    if (value === '') return true

                    return new Promise(async (resolve, reject) => {
                        await axios.post(this.existsUrl, {
                             'name': value
                        }).then(res => {
                            if (res.data.exists) this.nameErrors.push('Name must be unique.')
                            resolve(! res.data.exists)
                        });
                    })
                }
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

            this.$emit('save-dialog', this.editedItem);
        },
        validateName() {
            this.$v.editedItem.name.$touch();

            if (this.isValidatedNameValueUnchanged()) return;

            this.nameValidationErrors();
            this.cacheNameValidatedValue();
        },
        isValidatedNameValueUnchanged() {
            return this.$v.editedItem.name.$dirty && this.editedItem.name === this.validatedName
        },
        cacheNameValidatedValue() {
            this.validatedName = this.editedItem.name
        },
        nameValidationErrors() {
            this.nameErrors = [];
            if (!this.$v.editedItem.name.$dirty) this.nameErrors = []
            !this.$v.editedItem.name.maxLength && this.nameErrors.push('Name must be at most 55 characters long')
            !this.$v.editedItem.name.required && this.nameErrors.push('Name is required.')
            !this.$v.editedItem.name.isUnique.resolve
        },
        validateDescription() {
            this.$v.editedItem.description.$touch();
            this.descriptionErrors = []
            if (!this.$v.editedItem.description.$dirty) this.descriptionErrors = []
            !this.$v.editedItem.description.maxLength && this.descriptionErrors.push('Description must be at most 190 characters long')
        },
    },
    computed: {
        isValid() {
            return this.editedItem.name !== '' && this.nameErrors.length === 0 && this.descriptionErrors.length === 0
        },
    }
}
</script>
