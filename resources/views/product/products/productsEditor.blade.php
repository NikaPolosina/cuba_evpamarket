@extends('...layouts.master')

@section('content')
    <div class="table-responsive">
      <h1>{{ $company->company_name }} </h1>
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
                                    console.log(node.href);

                                    //$.ajax();

                                },
                                onNodeUnchecked: function (event, node) {
                                    $('.product_category').val('')

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
            <h1>Все продукты компании <a href="{{ url('products/create/'.$company->id) }}" class="btn btn-primary pull-right btn-sm">Добавить продукт</a></h1>
            <div class="table">


                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>№</th><th>Товар</th><th>Описание товара</th><th>Фото</th><th>Цена</th><th>Действие</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">

                    </tbody>
                </table>

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
    @endif
@endsection

