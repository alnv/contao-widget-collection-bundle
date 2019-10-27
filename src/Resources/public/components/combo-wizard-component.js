Vue.component( 'v-select', VueSelect.VueSelect );

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
        }
    },
    mounted: function () {
        this.fetch();
        this.selected = this.value;
    },
    template:
    '<div class="combo-wizard-component">' +
        '<div class="combo-wizard">' +
            '<input type="hidden" :name="name" :value="value">' +
            '<draggable v-model="selected" handle=".move" class="options-container">' +
                '<div v-for="select in selected" class="options">' +
                    '<div class="option first">' +
                        '<v-select @keypress.enter.native.prevent="" v-model="select.option" :options="options" :reduce="value => value.value" label="label"></v-select>' +
                    '</div>' +
                    '<div class="option second">' +
                        '<v-select @keypress.enter.native.prevent="" v-model="select.option2" :options="options2" :reduce="value => value.value" label="label"></v-select>' +
                    '</div>' +
                    '<div class="option operations">' +
                        '<button type="button" class="add" @click="addOption()"><img src="/system/themes/flexible/icons/copy.svg" alt="Neue Option hinzufügen"></button>' +
                        '<button v-if="selected.length > 1" type="button" class="delete" @click="deleteOption(select)"><img src="/system/themes/flexible/icons/delete.svg" alt="Option entfernen"></button>' +
                        '<button v-if="selected.length > 1" type="button" class="move"><img src="/system/themes/flexible/icons/drag.svg" alt="Option verschieben"></button>' +
                    '</div>' +
                '</div>' +
            '</draggable>' +
        '</div>' +
    '</div>'
});