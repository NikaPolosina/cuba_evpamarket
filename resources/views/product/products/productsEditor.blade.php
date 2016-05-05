@extends('...layouts.master')

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

                                        $.ajax({
                                            type: "POST",
                                            url: "/get-product-list",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                                companyId: '<?=$company->id?>',
                                                categoryId: node.href
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
@endsection

