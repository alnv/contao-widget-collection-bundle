Vue.component('v-select', VueSelect.VueSelect);
Vue.component( 'combo-wizard', {
    data: function () {
        return {
            options: [],
            options2: [],
            selected: []
        }
    },
    methods: {
        fetch: function () {
            this.$http.post( '/widget-collection/combo-wizard', {
                language: this.language,
                table: this.table,
                name: this.name,
                id: this.id
            },{
                emulateJSON: true,
                'Content-Type': 'application/x-www-form-urlencoded'
            }).then( function ( objResponse ) {
                if ( objResponse.body ) {
                    this.options = objResponse.body.options;
                    this.options2 = objResponse.body.options2;
                }
            });
        },
        addOption: function () {
            this.selected.push({})
        },
        deleteOption: function (select) {
            for ( var i = 0; i < this.selected.length; i++ ) {
                if ( this.selected[i] === select ) {
                    this.selected.splice( i, 1 );
                }
            }
        },
        isGroup: function ( select, index ) {
            if (!index) {
                return false;
            }
            if (select['option4']) {
                return false;
            }
            for (var i = index; i >= 0; i-- ) {
                if (this.selected[i]['option4']) {
                    return true;
                }
            }
            return false;
        }
    },
    watch: {
        selected: {
            handler: function () {
                this.value = JSON.stringify( this.selected );
            },
            deep: true
        }
    },
    props: {
        name: {
            type: String,
            required: true
        },
        table: {
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
        language: {
            type: String,
            default: 'en'
        },
        textField: {
            type: Boolean,
            default: false,
            required: false
        },
        group: {
            type: Boolean,
            default: false,
            required: false
        }
    },
    mounted: function () {
        this.fetch();
        this.selected = this.value;
    },
    template:
    '<div class="combo-wizard-component" v-bind:class="{\'group\': group, \'text\': textField}">' +
        '<div class="combo-wizard">' +
            '<input type="hidden" :name="name" :value="value">' +
            '<draggable v-model="selected" handle=".move" class="options-container">' +
                '<div v-for="( select, index ) in selected" class="options" v-bind:class="{\'col-4\': textField, \'col-2\': !textField, \'grouped\':isGroup(select,index)}">' +
                    '<div class="option first">' +
                        '<v-select @keypress.enter.native.prevent="" placeholder="-" :language="language" v-model="select.option" :options="options" :reduce="value => value.value" label="label"></v-select>' +
                    '</div>' +
                    '<div class="option second">' +
                        '<v-select @keypress.enter.native.prevent="" placeholder="-" :language="language"  v-model="select.option2" :options="options2" :reduce="value => value.value" label="label"></v-select>' +
                    '</div>' +
                    '<div class="option third" v-if="textField">' +
                        '<input type="text" v-model="select.option3" class="tl_text" placeholder="Abfragewert eintragen">' +
                    '</div>' +
                    '<div class="option operations">' +
                        '<button type="button" class="add" @click="addOption()"><img src="/system/themes/flexible/icons/copy.svg" alt="Neue Option hinzufügen"></button>' +
                        '<button v-if="selected.length > 1" type="button" class="delete" @click="deleteOption(select)"><img src="/system/themes/flexible/icons/delete.svg" alt="Option entfernen"></button>' +
                        '<button v-if="selected.length > 1" type="button" class="move"><img src="/system/themes/flexible/icons/drag.svg" alt="Option verschieben"></button>' +
                        '<div v-if="group">' +
                            '<input type="checkbox" v-model="select.option4">' +
                            '<label v-if="isGroup(select,index)">Gruppe auflösen</label>' +
                            '<label v-if="!isGroup(select,index)">Gruppe</label>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</draggable>' +
        '</div>' +
    '</div>'
});