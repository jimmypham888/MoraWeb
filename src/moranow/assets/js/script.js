'use strict';

jQuery('document').ready(function($) {

    if ($('.moranow-select').length) {
        $('.moranow-select').SumoSelect({
            search: true,
            searchText: 'Tìm counselor'
        });
    }

    setCouselorID();

    $('.moranow-select').on('change', function() {
        setCouselorID();
    });

    function setCouselorID() {
        var couselor_id = $('.moranow-select').find('option:selected').attr('data-id');

        $('#counselor-id').val(couselor_id);
    }
});