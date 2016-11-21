@extends('layouts.app')

@section('content')
    @include('layouts.header_menu')
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css"/>
    <link href="/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css"/>

    @include('layouts.breadcrumbs')
    <div class="col-sm-12">
        <div class="table-responsive">
            <h1 style="text-align: center">{{ $company->company_name }}</h1>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-2">
                {{--Подклучение страницы с статистикой продаж по данному магазину.--}}
                @include('company.shopStatistic')

                <a id="addCategory" href="{{url('/company-discount-setup', $company->id)}}">Установка накопительных скидок</a>
                <hr>
                <a id="addCategory" href="{{url('/category/category-setup', $company->id)}}">Добавить категорию</a>
                <hr>
                <h4>Мои категории</h4>
                <div class="allCategory form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                    <div id="custom-checkable" class="">

                    </div>
                </div>

            </div>

            <div class="col-sm-7">
                <div class="table" id="product_list">
                    @include('product.productListBody', array(
                                    'products' => $company->getProducts()->paginate($paginCnt),
                                    'category' => false
                                     ))
                </div>
            </div>
            <div class="col-sm-3">
                @include('company.registerUserHandle')

            </div>

        </div>

        @include('product.productModalEdit')
        @include('file_upload')


        <script>
           var file_uploader = '{{route('file_uploader')}}';
           var company_id = '{{$company->id}}';

                var categories      = [];
                var currentCategory = null;
                var data            = <?=$category?>;
                var images          = [];

                $(document).ready(function(){

                    /*---------------------Работа с катигориями-----------------------*/
                    $('#custom-checkable').treeview({

                        data            : data,
                        showCheckbox    : true,
                        enableLinks     : false,
                        onNodeChecked   : function(event, node){

                            $('#custom-checkable').treeview('selectNode', node.nodeId);
                            categories = [];
                            $('#product_list').html('');
                            var list = $('#custom-checkable').treeview('getChecked');
                            if(list.length > 1){
                                var tree = $('#custom-checkable').treeview(true);
                                list.forEach(function(element){
                                    if(node.href != element.href){
                                        tree.uncheckNode(element, {silent : true});
                                    }
                                });
                            }
                            currentCategory = node['id'];
                            categories.push(node['id']);
                            if(node['nodes'] && node['nodes'].length > 0){
                                var childrens = node['nodes'];
                                do{
                                    childrens.forEach(function(currentNode, key){
                                        categories.push(currentNode['id']);
                                        if(currentNode['nodes'].length > 0){
                                            currentNode['nodes'].forEach(function(nNode, k){
                                                childrens.push(nNode);
                                            });
                                        }
                                        childrens.splice(key, 1);
                                    });
                                }while(childrens.length > 0);
                            }
                            $.ajax({
                                type    : "POST",
                                url     : "/get-product-list",
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    companyId  : '<?=$company->id?>',
                                    categoryId : categories
                                },
                                success : function(msg){
                                    $('#product_list').html(msg);
                                }
                            });
                        },
                        onNodeUnchecked : function(event, node){

                            $('#custom-checkable').treeview('unselectNode', node.nodeId);

                            $('.product_category').val('')
                            $('#product_list').html('');
                            categories      = [];
                            currentCategory = null;
                            $.ajax({
                                type    : "POST",
                                url     : "/get-product-list",
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    companyId  : '<?=$company->id?>',
                                    categoryId : categories
                                },
                                success : function(msg){
                                    $('#product_list').html(msg);
                                }
                            });
                        },
                        onNodeSelected: function(event, node){
                            $('#custom-checkable').treeview('checkNode', node.nodeId);
                        },
                        onNodeUnselected: function(event, node){
                            $('#custom-checkable').treeview('uncheckNode', node.nodeId);
                        }
                    }).treeview('collapseAll');

                    $('#product_list').delegate('.paginate a', 'click', function(){
                        event.preventDefault();
                        var a   = $(this);
                        var url = a.attr("href");
                        var id  = url.substring(url.lastIndexOf('=') + 1)
                        if(id.length){
                            $.ajax({
                                type    : "POST",
                                url     : "/get-product-list?page=" + id,
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    companyId  : '<?=$company->id?>',
                                    categoryId : categories
                                },
                                success : function(msg){
                                    $('#product_list').html(msg);
                                }
                            });
                        }
                    });
                });

                $('.table').delegate('#destroycheck', 'click', function(){
                    event.preventDefault();
                    var selected = [];
                    var inputs   = $('.tBody').find('input:checked');
                    inputs.each(function(){
                        selected.push($(this).val());
                    });



                    var c_modal = new CModal({
                        title: 'Подтвердите Ваше действие',
                        body:'<h3>Вы уверены, что хотите удалить этот продукт?</h3>',
                        confirmBtn:'Удалить',
                        cancelBtn:'Отменить',
                        action: function(){


                            $.ajax({
                                type    : "POST",
                                url     : "/products/destroy-check",
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    id      : '<?=$company?>',
                                    checkId : selected
                                },
                                success : function(msg){
                                    inputs.each(function(){
                                        $(this).parents('tr').eq(0).remove();
                                    });
                                }
                            });

                        }
                    });
                    c_modal.show();



                });

                $('#product_list').delegate('.deleteCategoryButton', 'click', function(){
                    event.preventDefault();
                    var tr        = $(this).parents('tr');
                    var productId = tr.find('input[name="option"]').val();

                    var c_modal = new CModal({
                        title: 'Подтвердите Ваше действие',
                        body:'<h3>Вы уверены, что хотите удалить этот продукт?</h3>',
                        confirmBtn:'Удалить',
                        cancelBtn:'Отменить',
                        action: function(){

                            $.ajax({
                                type    : "POST",
                                url     :       '/product/destroy',
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    id : productId
                                },
                                success : function(msg){
                                    tr.remove();

                                },
                                error   : function(response){
                                    console.log('ajax went wrong');
                                }
                            });


                        }
                    });
                    c_modal.show();


                });

            </script>
        {!! HTML::script('/js/product_create_edit.js') !!}
        {!! HTML::script('/plugins/tinymce/tinymce_init.js') !!}


            <style>

                .error{
                    color: red;
                }

            </style>
    @endsection

