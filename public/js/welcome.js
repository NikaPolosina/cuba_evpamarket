$('.shop_show').on('click', function () {
    var parent = $(this).parents('.carentFindCompany');
   var id =  parent.find('#input_id').val();
    window.location= "/show-company/"+id;
});
$('.show-product').on('click', function(){
    var parent = $(this).parents('.carentFindProduct');
    var id = parent.find('.input_id_product').val();

    window.location= "/single-product/"+id;
});

