Vue.directive( 'nouislider', {
    bind: function ($el,binding,vnode) {
        noUiSlider.create($el, binding.value).on('change', function(values) {
            $el.value = values;
            $el.dispatchEvent( new Event( 'change', { bubbles: true } ) );
        });
    },
    update: function ($el,binding,vnode) {
        //
    }
});