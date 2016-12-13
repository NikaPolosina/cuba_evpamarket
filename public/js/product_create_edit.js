var nededPath, productId, mainImg, number;
$(function(){
    $('#fileupload').fileupload({
        url                : file_uploader,
        previewMaxWidth    : 300,
        previewMaxHeight   : 300,
        filesContainer     : $('.files'),
        uploadTemplateId   : null,
        downloadTemplateId : null,
        uploadTemplate     : null,
        downloadTemplate   : null,
        autoUpload         : true,
    })
        .on('fileuploadprocessalways', function(e, data){
        })
        .on('fileuploadadd', function(e, data){})
        .on('fileuploadsubmit', function(e, data){data.formData = {path : nededPath};})
        .on('fileuploaddone', function(e, data){

            var row   = $('<tr class="template-upload">' +
                '<td>' +
                '<div>' +
                '<button class="btn btn-danger delete" data-type="DELETE" data-url="'+data.result.files[0]["deleteUrl"]+'&path='+nededPath+'"> Удалить </button>' +
                '<div>Главная <input class="product_image" name="qe" type="radio" value="'+data.result.files[0].name+'"></div>' +
                '</div>' +
                '<span class="preview"></span></td>' +
                '<div class="error"></div>' +
                '</td>' +
                '</tr>');
            row.find('.preview').append(data.files[0].preview);
            $('.files').append(row);

        })
        .on('fileuploaddestroy', function (e, data) {

            if(productId){
                if(confirm('Вы уверены чт хотите удалить картинку ? Если Вы это сделаете, то она навсегда удалится с вашего альбома.')){
                    $(data.context.context).parents('tr').eq(0).remove();
                }else{
                    return false;
                }
            }else{
                $(data.context.context).parents('tr').eq(0).remove();
            }

        })
        .on('fileuploadfail', function(e, data){});
});
        /*
        * Функция для получения дополнительных параметров товарав при выборе категории.
        * */
        function getBlockWithadParam(id, data, item) {
            $.ajax({
                type    : "POST",
                url     : '/get-add-param/'+id,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {'value':data},
                success : function(response){
                    if(item){
                        item.html('');
                        item.append(response);
                    }else{
                        $('.mod').find('.add_param_holder').each(function(index, item){
                            $(item).html('');
                            $(item).append(response);
                        });
                    }
                }
            });
            
        }

$(document).ready(function() {
    /* Нажатие на кнопку изменить и создать новый*/
    $('#product_list').delegate('.open', 'click', function () {

        nededPath = 'temp/' + Date.now() + '/';
        productId = false;
        mainImg = '';
        $('.mod').find('.form-group').find('input[data-name="product_id"]').val('');
        $('.mod').find('.form-group').find('.product_id').val('');
        $('.mod').find('.form-group').find('select[data-name="category_name"]').val('');
        $('.mod').find('.form-group').find('input[data-name="name"]').val('');
        $('.mod').find('.form-group').find('input[data-name="description"]').val('');
        tinyMCE.activeEditor.setContent('');
        $('.mod').find('.form-group').find('input[data-name="photo"]').val('');
        $('.mod').find('.form-group').find('input[data-name="price"]').val('');
        $('.mod').find('.form-group').find('input[data-name="name"]').val('');
        $('.files').html('')
        $('.mod').find('.addParam').html('');


        $('.mod').find('.add_price_holder').html('');
        $('.mod').find('.add_param_holder').html('<p class="bg-warning" style="padding: 15px;">*Выбирите категорию для отображения дополнительных параметров</p>');


        if($(this).hasClass('edit')){
            var categoryId = '';
        }else{
            var categoryId = $('.table').find('.companyIdClass').val();
        }

        if(!categoryTitle){
            var categoryTitle = $('.table').find('.companyTitleClass').val();
        }

        var modalSelect = $('.mod').find('select[data-name="category_name"]');
        var modalSpan = $('.mod').find('.modalSpan');

        modalSelect.on('change', function () {
           if($(this).val().length) {
               getBlockWithadParam($(this).val(), [], false);
           }
        });

        if (categoryId.length && modalSelect.find('option[value="' + categoryId + '"]').length) {
            modalSelect.val(categoryId);
            modalSelect.hide();
            modalSpan.html(categoryTitle).show();

        } else {
            modalSelect.show();
            modalSpan.html('').hide();
        }

        if ($(this).hasClass('edit')) {
            
            number = $(this).parents('tr').eq(0).attr('data-number');


            if(window.id != undefined){
                var id = window.id;
            }else{
                var id = $(this).parents('tr').eq(0).find('.option').val();

            }


            $.ajax({
                type: "POST",
                url: "/products/edit-categoty",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {productId: id},
                success: function (msg) {
                    getBlockWithadParam(msg.productCategory.id, []);

                    
                    mainImg = msg.product.product_image;


                    $('.mod').find('select[name="category_name"]').hide();
                    $('.mod').find('.modalSpan').text(msg.productCategory.title).show();
                    $('.mod').find('.form-group').find('select[data-name="category_name"]').find("option[selected='selected']").attr('selected', false);
                    $('.mod').find('.form-group').find('.product_id').val(msg.product.id);
                    $('.mod').find('.form-group').find('select[data-name="category_name"]').val(msg.product.category_id);
                    $('.mod').find('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                    $('.mod').find('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                    $('.mod').find('.form-group').find('input[data-name="description"]').val(msg.product.product_description);

                    tinyMCE.activeEditor.setContent(msg.product.content);


                    if(msg.product.product_price){
                        $('.mod').find('[href="#single"]').click();
                        if($('.mod').find('#single').find('.add_param_holder').length){
                            if(msg.product.value.length){
                                JSON.parse(msg.product.value).forEach(function(value){
                                    getBlockWithadParam(msg.productCategory.id, JSON.stringify(value.add_param), $('.mod').find('#single').find('.add_param_holder'));
                                });
                            }
                        }
                        $('.mod').find('#single').find('input[data-name="price"]').val(msg.product.product_price);
                    }else{
                        $('.mod').find('[href="#several"]').click();
                        if($('.mod').find('#several').find('.add_price_origin').length){
                            var add_price_origin = $('.mod').find('#several').find('.add_price_origin').eq(0);
                            JSON.parse(msg.product.value).forEach(function(value){
                                var current = add_price_origin.clone();
                                current
                                .prepend('<div class="col-sm-12" style="margin-top: 5px;"><div class="col-sm-4">Имя (возможное указание модели товара).<span class="required_css">*</span></div><div></div><div class="col-sm-8"><input class="form-control" data-name="extra_name" type="text" name="name" value="'+value.name+'"><div>')
                                .append('<div class="col-sm-12"><span style="float: right;" class="btn remove_add_price"><button type="button" class="btn btn-danger">Удалить добавлнную цену</button></span></div>').show();

                                $('.mod').find('#several').find('.add_price_holder').append(current);
                                current.find('input[data-name="price"]').val(value.val);
                                getBlockWithadParam(msg.productCategory.id, JSON.stringify(value.add_param), current.find('.add_param_holder'));
                            });
                        }
                    }


                    $('.mod').find('.form-group').find('input[data-name="photo"]').val(msg.product.product_image);

                    $('.mod').find('#product_form').find('input[type="text"]').eq(0).focus();

                    productId = msg.product.id;
                    nededPath = '/companies/'+company_id+'/products/' + msg.product.id + '/';
                    $.ajax({
                        url: $('#fileupload').fileupload('option', 'url'),
                        dataType: 'json',
                        context: $('#fileupload')[0],
                        data: {
                            image: [],
                            path: nededPath
                        }
                    }).done(function (result) {

                        if (result.files.length) {
                            result.files.forEach(function (value) {
                                var row = $('<tr class="template-upload">' +
                                    '<td>' +
                                    '<div>' +
                                    '<button class="btn btn-danger delete ask" data-type="DELETE" data-url="' + value["deleteUrl"] + '&path=' + nededPath + '"> Удалиь </button>' +
                                    '<div>Главная <input ' + ((value.name == mainImg) ? 'checked' : '' ) + ' class="product_image" name="qe" type="radio" value="' + value.name + '"></div>' +
                                    '</div>' +
                                    '<span class="preview"></span></td>' +
                                    '<div class="error"></div>' +
                                    '</td>' +
                                    '</tr>');
                                row.find('.preview').append('<img src="' + value.thumbnailUrl + '">');
                                $('.files').append(row);

                            });
                        }


                    });


                    $('.mod').modal();

                }
            });

        } else {
            $('.mod').modal();
            number = $('#product_list').find('tr[data-number]');
            if (number && number.length > 0) {
                number = $(number[number.length - 1]).attr('data-number');
            } else {
                number = 1;
            }
        }

        modalSelect.trigger('change');
        

    });

    /* Выбор главной картинки (чекпоинт)*/
    $('body').delegate('.product_image', 'change', function(){
        $('.mod').find('form').find('input[name="product_image"]').val($(this).val());
    });

    /* Сохранение (кнопка сохранить изминения) изменения товаров при нажатии на кнопку (изменить)*/
    $('.submit_modal_form').on('click', function(){

        var modForm = $('.mod').find('form');


        if(modForm.length){

            var data = {};
            
            var inputs    = $('.mod').find('[data-name]');

            inputs.each(function(){
                data[$(this).attr('data-name')] = $(this).val();
            });
            data.content = tinyMCE.activeEditor.getContent();
            if(data.name.length == 0){
                $('[data-name="name"]').focus();
                return false;
            }
            if(data.description.length == 0){
                $('[data-name="description"]').focus();
                return false;
            }
            
            if(data.category_name.length == 0){
                $('.mod').find('.msgDenger').show();
                return false;
            }else{
                $('.mod').find('.msgDenger').hide();
            }


            $('div.error').hide();

            var path = '/products-category';
            var update = false;
            if(data.product_id.length > 0){
                path = '/products/ajax-update';
                update = true;
            }

            if(!productId)
                data.filesPath = nededPath;






            var price_type = modForm.find('.add_param_type').find('li.active').attr('data-type');

            var price_main_holder = modForm.find('div#'+price_type);

            var price_list = price_main_holder.find('.price_list');

            if(price_list.find('.add_price_origin').length){

                data['price'] = [];

                // foreach base prices
                price_list.find('.add_price_origin').each(function(index, ite){
                    ite = $(ite);

                    var price = {};
                    price['val'] = ite.find('[data-name="price"]').val();
                    price['name'] = ite.find('[data-name="extra_name"]').val();
                    price['add_param'] = {};

                    var add_param_holder = ite.find('.add_param_holder');

                    if(add_param_holder.find('.param_holder').length){
                        add_param_holder.find('.param_holder').each(function(ind, item){
                            item = $(item);

                            if(item.attr('data-key').length){

                                price['add_param'][item.attr('data-key')] = [];

                                switch (item.attr('data-type')){
                                    case 'checkbox':
                                        if(item.find('input:checked').length){
                                            item.find('input:checked').each(function(k, i){
                                                var single_add_param = {};

                                                single_add_param['val'] = $(i).val().trim();
                                                single_add_param['add_price'] = $(i).parent().find('.add_price').val().trim();
                                                single_add_param['add_price_type'] = $(i).parent().find('.add_price_type').val().trim();

                                                if(single_add_param['add_price'].length){
                                                    if(single_add_param['add_price_type'] == 'val'){
                                                        single_add_param['add_price'] = parseFloat(single_add_param['add_price']);
                                                    }else{
                                                        single_add_param['add_price'] = parseInt(single_add_param['add_price']);
                                                    }
                                                }else{
                                                    single_add_param['add_price'] = 0;
                                                }
                                                
                                                price['add_param'][item.attr('data-key')].push(single_add_param);
                                            });
                                        }
                                        
                                        break;
                                    case 'radio':
                                        if(item.find('input:checked').length){
                                            if(item.find('input:checked').val().length){
                                                var single_add_param = {};

                                                single_add_param['val'] = item.find('input:checked').val();
                                                single_add_param['add_price'] = item.find('input:checked').parent().find('.add_price').val();
                                                single_add_param['add_price_type'] = item.find('input:checked').parent().find('.add_price_type').val();

                                                console.log(single_add_param['add_price_type']);


                                                if(single_add_param['add_price'].length){
                                                    if(single_add_param['add_price_type'] == 'val'){
                                                        single_add_param['add_price'] = parseFloat(single_add_param['add_price']);
                                                    }else{
                                                        single_add_param['add_price'] = parseInt(single_add_param['add_price']);
                                                    }
                                                }else{
                                                    single_add_param['add_price'] = 0;
                                                }

                                                price['add_param'][item.attr('data-key')].push(single_add_param);
                                            }
                                        }

                                        break;
                                    case 'select':
                                        
                                        if(item.find('select').length){
                                            if(item.find('select').val().length){
                                                var single_add_param = {};
                                                
                                                single_add_param['val'] = item.find('select').val();
                                                single_add_param['add_price'] = item.find('select').parent().find('.add_price').val();
                                                single_add_param['add_price_type'] = item.find('select').parent().find('.add_price_type').val();

                                                if(single_add_param['add_price'].length){
                                                    if(single_add_param['add_price_type'] == 'val'){
                                                        single_add_param['add_price'] = parseFloat(single_add_param['add_price']);
                                                    }else{
                                                        single_add_param['add_price'] = parseInt(single_add_param['add_price']);
                                                    }
                                                }else{
                                                    single_add_param['add_price'] = 0;
                                                }

                                                price['add_param'][item.attr('data-key')].push(single_add_param);
                                                
                                            }
                                        }

                                        break;
                                    case 'input':
                                        if(item.find('input').length){
                                            var single_add_param = {};

                                            if(item.find('input[data-name="owner_field"]').length){
                                                single_add_param['val'] = item.find('input[data-name="owner_field"]').val();
                                            }else{
                                                single_add_param['val'] = item.find('input[data-name="client_field"]').val();
                                            }
                                            single_add_param['add_price'] = 0;
                                            single_add_param['add_price_type'] = '';

                                            price['add_param'][item.attr('data-key')].push(single_add_param);

                                        }
                                        break;
                                }
                            }
                        });

                    }

                    data['price'].push(price);

                });
            }

            $.ajax({
                type    : "POST",
                url     : path,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {
                    company_id : company_id,
                    product    : data,
                    x : number
                },
                success : function(data){

                    // return false;

                    if(data.error){
                        $.each(data.error, function( index, value ) {

                            $('div[data-id="'+index+'"]').find('span').text(value);
                            $('div[data-id="'+index+'"]').show();
                        });
                        return false;
                    }

                    if(window.id != undefined){
                        window.location = '';
                    }

                    var tr = $(data);
                    var id = tr.find('.option').val();

                    if(update){
                        var old = $('.tBody').find('.option[value="'+id+'"]').parents('tr').eq(0);
                        old.after(tr);
                        old.remove();

                        $('[data-name="description"]').val('');
                        tinyMCE.activeEditor.setContent('');

                    }else{
                        $('.tBody').append(tr);
                        inputs.each(function(){
                            if($(this).attr('data-name') != 'category_name'){
                                $(this).val('');
                            }
                        });
                    }

                    $('.mod').modal('hide');
                }
            });

        }
        /*На закрытие модалки чистим все поля формы*/
        $('#myModal').on('hidden.bs.modal', function (e) {
            inputs.each(function(){
                if($(this).attr('data-name') != 'category_name'){
                    $(this).val('');
                }
            });
            $('[data-name="description"]').val('');
            tinyMCE.activeEditor.setContent('');
        })

    });

    $('.mod').find('.add_price').on('click', function(){
        var add_price_origin = $('.mod').find('#several').find('.add_price_origin').eq(0);
        $('.mod').find('#several').find('.price_list').append(add_price_origin.clone()
        .prepend('<div class="col-sm-12" style="margin-top: 5px;"><div class="col-sm-4">Имя (возможное указание модели товара). <span class="required_css">*</span>  </div><div class="col-sm-8"><input class="form-control" data-name="extra_name" type="text" name="name" value=""></div></div>')
        .append('<div class="col-sm-12"><span style="float: right;" class="btn remove_add_price"><button type="button" class="btn btn-danger">Удалить добавлнную цену</button></span></div>').show());

    });

    $('.mod').delegate('.remove_add_price', 'click', function(){
        $(this).parents('.add_price_origin').eq(0).remove();
        return;
    });

    $('.mod').delegate('.add_param_button', 'click', function(){
        $(this).parent().find('div').eq(0).toggle();
    });

});
