import Vue from "vue";
import VueI18n from "vue-i18n";

Vue.use(VueI18n);

export default new VueI18n({
    locale: "en",
    fallbackLocale: "en",
    messages: {
        en: {
            'Dashboard': 'Dashboard',
            'Expense Categories': 'Expense Categories'
        },
        el: {
            'Dashboard': 'Πίνακας Ελέγχου',
            'Expense Categories': 'Κατηγορίες Εξόδων'
        }
    }
});
