import Vue from "vue";
import VueI18n from "vue-i18n";

Vue.use(VueI18n);

const numberFormats = {
    "en": {
        currency: {
            style: "currency",
            currency: "EUR"
        }
    },
    "el": {
        currency: {
            style: "currency",
            currency: "EUR"
        }
    }
}

const setDateTimeFormats = {
    short: {
        year: "numeric",
        month: "short",
        day: "numeric"
    },
    long: {
        year: "numeric",
        month: "numeric",
        day: "numeric",
        hour: "numeric",
        minutes: "numeric"
    }
}

const dateTimeFormats = {
    en: setDateTimeFormats,
    el: setDateTimeFormats
}

function loadLocaleMessages() {
    const locales = require.context(
        "./locales",
        true,
        /[A-Za-z0-9-_,\s]+\.json$/i
    );
    const messages = {};
    locales.keys().forEach(key => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i);
        if (matched && matched.length > 1) {
            const locale = matched[1];
            messages[locale] = locales(key);
        }
    });

    return messages;
}

export default new VueI18n({
    locale: "en",
    fallbackLocale: "en",
    messages: loadLocaleMessages(),
    dateTimeFormats,
    numberFormats
});
