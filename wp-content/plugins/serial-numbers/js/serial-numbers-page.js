jQuery(document).ready(function ($) {

    $(document).on('change', '.manage-stock', function () {
        var value = $(this).val();
        var stockWrapper = $(this).closest('.product-serial-number-wrapper').find('.stock-wrapper');
        if (value === 'yes') {
            stockWrapper.show();
        } else {
            stockWrapper.hide();
        }
    });
    $('.manage-stock').change();

    function updateNumberOfSerialNumbers() {
        $('.product-serial-number-wrapper').each(function () {
            if ($(this).find('.serial-numbers input').length === 0) {
                $(this).find('.no-serial-numbers').show();
            } else {
                $(this).find('.no-serial-numbers').hide();
            }
        });
    }
    updateNumberOfSerialNumbers();

    $(document).on('click', '.add-serial-number', function (event) {
        event.preventDefault();
        var newSerialNumberHtml = serial_numbers_page_settings.new_serial_number;
        var new_serial_number_id = 0;
        $(this).closest('.product-serial-number-wrapper').find('.serial-number-id').each(function () {
            var serialNumber = parseInt($(this).val());
            if (serialNumber > new_serial_number_id) {
                new_serial_number_id = serialNumber;
            }
        });
        new_serial_number_id = new_serial_number_id + 1;
        newSerialNumberHtml = newSerialNumberHtml.replace(new RegExp('serial_number_id', 'g'), new_serial_number_id);
        var post_id = $(this).closest('.product-serial-number-wrapper').find('.post-id').val();
        newSerialNumberHtml = newSerialNumberHtml.replace(new RegExp('post_id', 'g'), post_id);
        $(this).closest('.product-serial-number-wrapper').find('.serial-numbers').append(newSerialNumberHtml);
        updateNumberOfSerialNumbers();
    });

    $('.serial-numbers').on('click', '.remove-serial-number', function (event) {
        event.preventDefault();
        var serialNumberToRemove = $(this).closest('.serial-number');
        setTimeout(function () {
            serialNumberToRemove.remove();
        }, 500);
        serialNumberToRemove.hide();
        updateNumberOfSerialNumbers();
    });

});