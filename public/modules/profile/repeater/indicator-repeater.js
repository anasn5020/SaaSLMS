var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
            $('.mt-repeater').each(function(){
                $(this).repeater({
                    show: function () {
                        $(this).slideDown();
                    },

                    hide: function (deleteElement) {
                        if(confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },

                    ready: function (setIndexes) {

                    },

                    isFirstItemUndeletable: true

                });
            });
        }

    };

}();

jQuery(document).ready(function() {
    FormRepeater.init();
});
