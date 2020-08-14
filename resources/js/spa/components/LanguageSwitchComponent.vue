<template>
    <div class="pa-2 mb-10 text-center">
        <v-btn text @click="setLocale('en')" :color="this.$i18n.locale === 'en' ? 'blue' : 'black'">En</v-btn>
        <v-btn text @click="setLocale('el')" :color="this.$i18n.locale === 'el' ? 'blue' : 'black'">Ελ</v-btn>
    </div>
</template>

<script>
export default {
    methods: {
        setLocale(locale) {
            localStorage.setItem('locale', locale);
            this.$i18n.locale = locale;
        }
    }
}
</script>
