
@extends('..admin.header_footer_layout')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>





<form action="index.html" class="form-horizontal form-row-seperated">
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-md-3">Родительская категория</label>
            <div class="col-md-4">
                <select class="bs-select form-control parent-control">


                    @foreach($category_parent as $item)



                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <input data-parent="0" class="form-control" type="text"/>
            </div>


        </div>
     </div>
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-md-3">Дочерняя категория</label>
            <div class="col-md-4">
                <select class="bs-select form-control child-control">
                    @if(count($child_category))
                        @foreach($child_category as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-4">
                <input  data-name="data_child_2" data-parent="{{$category_parent[0]->id}}" class="form-control" type="text"/>
            </div>

        </div>


     </div>
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-md-3">Имя категрии</label>
            <div class="col-md-4">
                <input  data-name="data_child_3" class="form-control" data-parent="@if(count($child_category)){{$child_category[0]->id}}@endif" type="text"/>
            </div>


            <div data-id ="message" class="alert alert-success col-md-4" style="display: none"></div>
            <div data-id ="message_danger" class="alert alert-danger col-md-4" style="display: none"></div>

        </div>
     </div>
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-4">
                <div class="form-actions">
                    <button type="button" class="btn default">Отменить</button>
                    <button type="button" class="btn green">Добавить</button>
                </div>
            </div>
        </div>
    </div>




</form>



<script>
    
    $('.parent-control').on('change', function(){
        var id = $(this).val();
        event.preventDefault();
        $.ajax({
            type    : "POST",
            url     : "/admin/add-category-list",
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                id : id
            },
            success : function(msg){
                $('input[data-name="data_child_2"]').attr('data-parent', id);
                $('.child-control').html('');

                if(msg.category_child.length > 0){
                    $.each(msg.category_child, function( index, value ) {

                        $('.child-control').append("<option value="+(value.id+">"+value.title+"</option>"));
                    });
                }
                $('input[data-name="data_child_3"]').attr('data-parent', $('.child-control').val());

            }
        });
    })
    $('button.green').on('click', function () {

        var arr = [];
        var arr2 = {};


        $.each($('input[data-parent]'), function( index, value ) {
            var parent_id = $(value).attr('data-parent');
            var title = $(value).val();
            if(title.length > 0){
                arr2["parent_id"] = parent_id;
                arr2["title"] = title;
                arr.push(arr2);
                arr2 = {};
            }
        });

        if(arr.length > 0) {
            $.ajax({
                type: "POST",
                url: "/admin/add-item",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    arr: JSON.stringify(arr)
                },
                success: function (msg) {

                    $('input[data-parent]').val('');

                    $('div[data-id ="message"]').text('Категории были добавлены в список.').toggle('slow');
                    setTimeout(function () {
                        $('div[data-id ="message"]').text('').toggle('slow');
                    }, 4000);


                }
            });
        }else{
            $('div[data-id ="message_danger"]').text('Поле пустое, заполните поле формы.').toggle('slow');
            setTimeout(function () {
                $('div[data-id ="message_danger"]').text('').toggle('slow');
            }, 4000);
        }

   
            

   

});


</script>
@endsection