
(function( $ ){
    $('#post_author_override').combobox();
        $('#btnChangeDropDownItems').on('click',function(){
            var myOptions = {
                val1 : 'text1',
                val2 : 'text2'
            };
            var mySelect = $('#post_author_override');
            mySelect.empty();
            $.each(myOptions, function(val, text) {
                mySelect.append(
                    $('<option></option>').val(val).html(text)
                );
            });        
        });

    $('#btnShowSelected').on('click',function(){
            alert( $('#post_author_override').val() );
    });

}(jQuery));


