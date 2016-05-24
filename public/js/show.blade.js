

$('.show-product').on('click', function(){
    var parent = $(this).parents('.carentFindProduct');
    var id = parent.find('.input_id_product').val();

    window.location= "/single-product/"+id;
});


