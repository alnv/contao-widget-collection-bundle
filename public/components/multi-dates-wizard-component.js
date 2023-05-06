Vue.component( 'multi-dates-wizard', {
    data: function () {
        return {
            rows: [],
            error: ''
        }
    },
    methods: {
        addDate: function (row,index) {
            let objRow = {};
            objRow.day = row.day;
            objRow.from = row.from;
            objRow.to = row.to;
            this.rows.splice(index+1, 0, objRow);
        },
        removeDate: function (row) {
            for (let i = 0; i < this.rows.length; i++) {
                if (this.rows[i] === row) {
                    this.rows.splice(i, 1);
                }
            }
        },
        isValidDate: function (value) {
            if (value === '' || value === null) {
                return true;
            }
            let objDate = moment(value, this.dateFormat);
            return objDate.isValid();
        },
        isValidTimestamp: function (value) {
            let objDate = moment(value, 'X');
            return objDate.isValid();
        },
        castDate2TimeStamp: function (value) {
            if (value === '' || value === null) {
                return value;
            }
            if (this.isValidDate(value)) {
                let objDate = moment(value, this.dateFormat);
                return objDate.format('X');
            }
            return 0;
        },
        castTimeStamp2Date: function (value) {
            if (value === '' || value === null) {
                return value;
            }
            if (this.isValidTimestamp(value)) {
                let objDate = moment(value, 'X');
                return objDate.format(this.dateFormat);
            }
            return value;
        }
    },
    watch: {
        rows: {
            handler: function (rows) {
                this.error = '';
                let arrValues = [];
                for (let i = 0; i < rows.length; i++) {
                    let objRow = {};
                    for (var name in rows[i]) {
                        if (rows[i].hasOwnProperty(name)) {
                            switch (name) {
                                case 'from':
                                case 'to':
                                    if (!this.isValidDate(rows[i][name])) {
                                        this.error = 'Bitte beachten Sie, dass Datumsformat ' + this.dateFormat;
                                    }
                                    objRow[name] = this.castDate2TimeStamp(rows[i][name]);
                                    break;
                                default:
                                    objRow[name] = rows[i][name];
                                    break;
                            }
                        }
                    }
                    arrValues.push(objRow);
                }
                this.value = JSON.stringify(arrValues);
            },
            deep: true
        }
    },
    mounted: function () {
        this.error = '';
        if ( typeof this.value === 'object' && this.value.length ) {
            for (let i = 0; i < this.value.length; i++) {
                let objRow = {};
                for (var name in this.value[i]) {
                    if (this.value[i].hasOwnProperty(name)) {
                        switch (name) {
                            case 'from':
                            case 'to':
                                if (!this.isValidTimestamp(this.value[i][name])) {
                                    this.error = 'Bitte beachten Sie, dass Datumsformat ' + this.dateFormat;
                                }
                                objRow[name] = this.castTimeStamp2Date(this.value[i][name]);
                                break;
                            default:
                                objRow[name] = this.value[i][name];
                                break;
                        }
                    }
                }
                this.rows.push(objRow);
            }
        }
        else {
            this.rows.push({
                from: null,
                to: null
            });
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
        },
        useDay: {
            type: Boolean,
            required: false
        },
        dateFormat: {
            type: String,
            required: false,
            default: 'DD.MM.YYYY'
        },
    },
    template:
        '<div class="multi-dates-wizard-component">' +
            '<div class="multi-dates-wizard">' +
                '<input type="hidden" :name="name" :value="value">' +
                '<div class="table">' +
                    '<div class="thead">' +
                        '<div class="tr">' +
                            '<div v-if="useDay" class="th from">Wochentag</div>' +
                            '<div class="th from">Von</div>' +
                            '<div class="th to">Bis</div>' +
                            '<div class="th operation"></div>' +
                        '</div>' +
                    '</div>' +
                    '<draggable v-model="rows" handle=".drag" class="tbody">' +
                        '<div class="tr" v-for="(row, index) in rows">' +
                            '<div v-if="useDay" class="td day">' +
                                '<input type="text" v-model="row.day">' +
                            '</div>' +
                            '<div class="td date from">' +
                                '<input type="text" v-model="row.from">' +
                            '</div>' +
                            '<div class="td date to">' +
                                '<input type="text" v-model="row.to">' +
                            '</div>' +
                            '<div class="td operations">' +
                                '<button type="button" class="add" @click="addDate(row, index)"><img src="/system/themes/flexible/icons/copy.svg" alt="Hinzufügen"></button>' +
                                '<button v-if="rows.length > 1" type="button" class="delete" @click="removeDate(row)"><img src="/system/themes/flexible/icons/delete.svg" alt="Entfernen"></button>' +
                                '<button v-if="rows.length > 1" type="button" class="drag"><img src="/system/themes/flexible/icons/drag.svg" alt="Verschieben"></button>' +
                            '</div>' +
                        '</div>' +
                    '</draggable>' +
                '</div>' +
                '<p class="error" v-if="error" v-html="">{{ error }}</p>' +
            '</div>' +
        '</div>'
});