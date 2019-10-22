Vue.component( 'v-select', VueSelect.VueSelect );
Vue.component( 'ajax-select-menu', {
    data: function () {
        return {
            options: []
        }
    },
    methods: {
        fetchOptions: function ( search ) {
            if ( search.length < 2 ) {
                return null;
            }
            this.$http.get( '/widget-collection/ajax-select-options', {
                params: {
                    id: this.id,
                    search: search,
                    name: this.name
                }
            }).then( function ( objResponse ) {
                if ( objResponse.body ) {
                    this.options = objResponse.body.options;
                }
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
            type: String
        },
        multiple: {
            type: Boolean,
            default: false
        },
        placeholder: {
            type: String,
            default: ''
        }
    },
    template:
    '<div class="ajax-select-menu-component">' +
        '<div class="ajax-select-menu">' +
            '<input type="hidden" :name="name" :value="value">' +
            '<v-select @search="fetchOptions" @keypress.enter.native.prevent="" :placeholder="placeholder" :multiple="multiple" :id="\'ctrl_\' + id" v-model="value" :options="options" :reduce="value => value.value" label="label">' +
                '<div slot="no-options">-</div>'+
            '</v-select>' +
        '</div>' +
    '</div>'
});
