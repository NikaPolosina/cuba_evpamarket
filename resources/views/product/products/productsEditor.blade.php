@extends('...layouts.app')

@section('content')

    <div style="border: solid 2px darkgrey; padding: 10px;">
        <div class="table-responsive">

          <h1 style="text-align: center">{{ $company->company_name }} </h1>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-3">
                <hr>
                <h4>Категории товаров</h4>
                <hr>
                <div class="allCategory form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">

                    <div id="custom-checkable" class=""></div>
                    <script>
                        var categories = [];

                        var data = <?=$category?>


                                $('#custom-checkable').treeview({
                                    data: data,
                                    showCheckbox: true,
                                    enableLinks: true,
                                    onNodeChecked: function(event, node) {
                                        $('#product_list').html('');
                                        var list = $('#custom-checkable').treeview('getChecked');
                                        if(list.length > 1){
                                            var tree = $('#custom-checkable').treeview(true);
                                            list.forEach(function(element){
                                                if(node.href != element.href){
                                                    tree.uncheckNode(element, { silent: true });
                                                }
                                            });
                                        }



                                        categories.push(node['id']);

                                        if(node['nodes'].length > 0){
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
                                            type: "POST",
                                            url: "/get-product-list",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                                companyId: '<?=$company->id?>',
                                                categoryId: categories
                                            },
                                            success: function(msg){
                                                    $('#product_list').html(msg);
                                            }
                                        });

                                    },
                                    onNodeUnchecked: function (event, node) {
                                        $('.product_category').val('')
                                        $('#product_list').html('');


                                    }
                                }).treeview('collapseAll');
                        $('.allCategory').click(function(){
                            //действия
                            return false;
                        });


                    </script>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="table" id="product_list">

                </div>

            </div>
        </div>



        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            </div>
    </div>
    @endif
    <script>
        $(document).ready(function(){
            $('#product_list').delegate('.paginate a', 'click',  function(){
                event.preventDefault();
                

                var a = $(this);
                var url = a.attr("href");
                var id = url.substring(url.lastIndexOf('=') + 1)
                if(id.length){

                    $.ajax({
                        type: "POST",
                        url: "/get-product-list?page="+id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            companyId: '<?=$company->id?>',
                            categoryId: categories
                        },
                        success: function(msg){
                            $('#product_list').html(msg);
                        }
                    });

                }

            });
        });

    </script>

    <script>

        $('#product_list').delegate('.editCategoryButton', 'click', function(){
            $('.form-group ').find('.productId').val('');

            event.preventDefault();
            var id = $(this).parents('tr').eq(0).find('.option').val();

            var inputs = $('.addProductCategory').find('[data-name]');
            inputs.each(function() {
                if($(this).attr('data-name') != 'category_id'){
                    $(this).val('');
                }
            });

            $.ajax({
                type: "POST",
                url: "/products/edit-categoty",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    productId: id
                },
                success: function(msg){

                    $('.form-group').find('.product_id').val(msg.id);
                    $('.form-group').find('input[data-name="name"]').val(msg.product_name);
                    $('.form-group').find('input[data-name="description"]').val(msg.product_description);
                    $('.form-group').find('input[data-name="photo"]').val(msg.product_image);
                    $('.form-group').find('input[data-name="price"]').val(msg.product_price);

                    $('.addProductCategory').show();
                    $('#product_form').find('input.create').hide();
                    $('#product_form').find('input.update').show();

                    $('#product_form').find('input[type="text"]').eq(0).focus();


                }
            });

        });

        $('#product_list').delegate('.update', 'click', function(){
            var buttom = $(this);
//            buttom.disable();

            event.preventDefault();

            var data = {};
            data['id'] = $('.form-group').find('.product_id').val();
            data['name'] = $('.form-group').find('input[data-name="name"]').val();
            data['description'] = $('.form-group').find('input[data-name="description"]').val();
            data['photo'] = $('.form-group').find('input[data-name="photo"]').val();
            data['price'] = $('.form-group').find('input[data-name="price"]').val();

            $.ajax({
                type: "POST",
                url: "/products/ajax-update",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(msg){
//                    buttom.enable();

                    $('.addProductCategory').hide();
                    var currentTr = $('#product_list').find('.option[value="'+data.id+'"]').parents('tr').eq(0);

                    currentTr.after(msg);


                    currentTr.remove();

                }
            });

        });

    </script>

@endsection

