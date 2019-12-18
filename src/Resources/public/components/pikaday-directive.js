Vue.directive( 'pikaday', {
    bind: function ($el,binding,vnode) {
        binding.value = binding.value || {};
        let objSettings = {
            field: $el,
            format: binding.value.format ? binding.value.format : 'DD.MM.YYYY',
            i18n: {
                previousMonth : 'Vorheriger Monat',
                nextMonth     : 'Nächster Monat',
                months        : [ 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember' ],
                weekdays      : [ 'Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag' ],
                weekdaysShort : [ 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' ]
            },
            onSelect: function () {
                $el.value = this.toString();
                $el.dispatchEvent( new Event( 'input', { bubbles: true } ) );
            }
        };
        for ( let option in binding.value ) {
            if ( binding.value.hasOwnProperty( option ) ) {
                let value = binding.value[option];
                switch ( option ) {
                    case 'maxDate':
                    case 'minDate':
                        value = moment(value,objSettings.format).toDate();
                        break;
                }
                objSettings[ option ] = value;
            }
        }
        this.picker = new Pikaday(objSettings);
    },
    update: function ($el,binding,vnode) {
        binding.value = binding.value || {};
        for ( let option in binding.value ) {
            if ( binding.value.hasOwnProperty( option ) ) {
                let value = binding.value[option];
                switch ( option ) {
                    case 'maxDate':
                        this.picker.setMaxDate( moment(value,this.picker._o.format).toDate() );
                        break;
                    case 'minDate':
                        this.picker.setMinDate( moment(value,this.picker._o.format).toDate() );
                        break;
                }
            }
        }
    }
});