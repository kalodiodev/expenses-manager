import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import el from 'vuetify/es5/locale/el'
import en from 'vuetify/es5/locale/en'
import colors from "vuetify/lib/util/colors";
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify)
const vuetify = new Vuetify({
    theme: {
        themes: {
            light: {
                primary: colors.blue.darken1, // #E53935
            },
        },
    },
    lang: {
        locales: { el, en },
        current: 'el',
    },
});

export default vuetify;
