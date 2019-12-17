let strDateFormat = 'DD.MM.YYYY';
let objI18n = {
    previousMonth : 'Vorheriger Monat',
    nextMonth     : 'Nächster Monat',
    months        : [ 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember' ],
    weekdays      : [ 'Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag' ],
    weekdaysShort : [ 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' ]
};
Vue.directive( 'pikaday', {
    bind: function ($el) {
        new Pikaday({
            field: $el,
            i18n: objI18n,
            format: strDateFormat,
            onSelect: function() {
                $el.value = this.toString();
                $el.dispatchEvent( new Event( 'input', { bubbles: true } ) );
            }
        });
    }
});