Vue.component( 'multi-dates-wizard', {
    data: function () {
        return {
            rows: [],
            error: '',
            dateFormat: 'DD.MM.YYYY' // @todo improve
        }
    },
    methods: {
        addDate: function (row,index) {
            let objRow = {};
            objRow.from = row.from;
            objRow.to = row.to;
            this.rows.splice( index+1, 0, objRow);
        },
        removeDate: function (row) {
            for ( let i = 0; i < this.rows.length; i++ ) {
                if ( this.rows[i] === row ) {
                    this.rows.splice( i, 1 );
                }
            }
        }
    },
    watch: {
        rows: {
            handler: function (rows) {
                this.error = '';
                let arrValues = [];
                let blnError = false;
                for ( let i = 0; i < rows.length; i++ ) {
                    let objRow = rows[i];
                    let objNewRow = {};
                    objNewRow.from = objRow.from;
                    objNewRow.to = objRow.to;
                    let objFromDate = moment( objRow.from, this.dateFormat );
                    let objToDate = moment( objRow.to, this.dateFormat );
                    if ( objFromDate.isValid() && objToDate.isValid() ) {
                        objNewRow.from = objFromDate.format('X');
                        objNewRow.to = objToDate.format('X');
                    } else {
                        blnError = true;
                    }
                    arrValues.push( objNewRow );
                }
                if ( blnError ) {
                    this.error = 'Das eingegebene Datum ist ungültig.';
                }
                this.value = JSON.stringify( arrValues );
            },
            deep: true
        }
    },
    props: {
        name: {
            type: String,
            required: true
        },
        id: {
            type: String,
            required: true
        },
        value: {
            type: Array,
            required: true
        }
    },
    mounted: function () {
        this.error = '';
        let blnError = false;
        if ( typeof this.value === 'object' && this.value.length ) {
            for ( let i = 0; i < this.value.length; i++ ) {
                let objRow = this.value[i];
                if ( objRow.hasOwnProperty('from') && objRow.hasOwnProperty('to') ) {
                    let objFromDate = moment( objRow.from, 'X' );
                    let objToDate = moment( objRow.to, 'X' );
                    if ( objFromDate.isValid() && objToDate.isValid() ) {
                        objRow.from = objFromDate.format( this.dateFormat );
                        objRow.to = objToDate.format( this.dateFormat );
                    } else {
                        blnError = true;
                    }
                    this.rows.push(objRow);
                }
            }
        }
        else {
            this.rows.push({
                from: moment().format( this.dateFormat ),
                to: moment().format( this.dateFormat )
            });
        }
        if ( blnError ) {
            this.error = 'Bitte geben Sie ein gültiges Datum ein.';
        }
    },
    template:
        '<div class="multi-dates-wizard-component">' +
            '<div class="multi-dates-wizard">' +
                '<input type="hidden" :name="name" :value="value">' +
                '<div class="table">' +
                    '<div class="thead">' +
                        '<div class="tr">' +
                            '<div class="th from">Von</div>' +
                            '<div class="th to">Bis</div>' +
                            '<div class="th operation"></div>' +
                        '</div>' +
                    '</div>' +
                    '<draggable v-model="rows" handle=".drag" class="tbody">' +
                        '<div class="tr" v-for="(row, index) in rows">' +
                            '<div class="td date from">' +
                                '<input type="text" v-model="row.from" v-pikaday>' +
                            '</div>' +
                            '<div class="td date to">' +
                                '<input type="text" v-model="row.to" v-pikaday="{ minDate: row.from }">' +
                            '</div>' +
                            '<div class="td operations">' +
                                '<button type="button" class="add" @click="addDate(row, index)"><img src="/system/themes/flexible/icons/copy.svg" alt="Hinzufügen"></button>' +
                                '<button v-if="rows.length > 1" type="button" class="delete" @click="removeDate(row)"><img src="/system/themes/flexible/icons/delete.svg" alt="Entfernen"></button>' +
                                '<button v-if="rows.length > 1" type="button" class="drag"><img src="/system/themes/flexible/icons/drag.svg" alt="Verschieben"></button>' +
                            '</div>' +
                        '</div>' +
                    '</draggable>' +
                '</div>' +
                '<p class="error" v-if="error">{{ error }}</p>' +
            '</div>' +
        '</div>'
});