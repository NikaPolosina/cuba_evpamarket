@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')


    <div class="col-sm-10 col-md-offset-1">

        <div class="company_tile_category">
            <h2 style="text-align: center">Редактор категорий магазина</h2>
            <h2>Магазин {{$company->company_name}}</h2>
            <div class="col-sm-12">
                        <hr/>
                        <div class="footer_button" style="float: right;">
                            <a href="/product-editor/{{$company->id}}" class="btn btn-primary">Перейти в магазин</a>
                        </div>
                    </div>
        </div>

        <div class="col-sm-10 col-md-offset-1">

            <div class="progress" style="display: none;">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">45% Complete</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="category_system">
                    <h4>Все категории</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success add_categories">Добавить выбранные</button>
                    </div>
                    <div id="custom-checkable"></div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="category_user">
                    <h4>Kатегории магазина</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger remove_categories">Удалить выбранные</button>
                    </div>
                    <div id="custom-checkable1" class="">

                    </div>
                </div>
            </div>



        </div>

        <div class="footer_button" style="float: right;">
            <a href="" class="btn btn-default">Отменить изменения</a>
            <a href="" class="btn btn-success">Сохранить изменения</a>

        </div>
    </div>


    <script>


        var data = <?=json_encode($categories) ?> ;
        $(document).ready(function(){
            var addButton    = $('.add_categories');
            var removeButton = $('.remove_categories');
            var progress     = $('.progress');

            $('#custom-checkable').treeview({
                data            : data,
                showCheckbox    : true,
                enableLinks     : false,
                onNodeChecked   : function(event, node){
                    if(node['nodes'].length > 0){
                        node['nodes'].forEach(function(currentNode, key){
                            $('#custom-checkable').treeview('checkNode', currentNode['nodeId']);
                        });
                    }
                },
                onNodeUnchecked : function(event, node){
                    if(node['nodes'].length > 0){
                        node['nodes'].forEach(function(currentNode, key){
                            $('#custom-checkable').treeview('uncheckNode', currentNode['nodeId']);
                        });
                    }
                }
            }).treeview('collapseAll');

            addButton.on('click', function(){
                if($('#custom-checkable').treeview('getChecked').length > 0){
                    addButton.attr('disabled', true);
                    removeButton.attr('disabled', true);
                    progress.show();
                    var categories = [];
                    $('#custom-checkable').treeview('getChecked').forEach(function(currentNode, key){
                        categories.push(currentNode['id']);
                    });
                    $.ajax({
                        type    : "POST",
                        url     : '{{route('attach_categories')}}',
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : {
                            company    : '{{$company->id}}',
                            categories : categories
                        },
                        success : function(response){
                            $('#custom-checkable').treeview('getChecked').forEach(function(currentNode, key){
                                $('#custom-checkable').treeview('uncheckNode', currentNode['nodeId']);
                            });
                            $('#custom-checkable').treeview('collapseAll', {silent : true});
                            var data = {};
                            if(response.categories.length > 0){
                                data = response.categories;
                            }
                            buildTree(data);
                            addButton.attr('disabled', false);
                            removeButton.attr('disabled', false);
                            progress.hide();
                        },
                        error   : function(){
                            alert('System error');
                            addButton.attr('disabled', false);
                            removeButton.attr('disabled', false);
                            progress.hide();
                        }
                    });
                }
            });

            removeButton.on('click', function(){

                if($('#custom-checkable1').treeview('getChecked').length > 0){

                    if(!confirm('Все товары в выбранных категория будут удалены. ')){
                        return false;
                    }
                    addButton.attr('disabled', true);
                    removeButton.attr('disabled', true);
                    progress.show();
                    if($('#custom-checkable1').treeview('getChecked').length > 0){
                        var categories = [];
                        $('#custom-checkable1').treeview('getChecked').forEach(function(currentNode, key){
                            categories.push(currentNode['id']);
                        });
                        $.ajax({
                            type    : "POST",
                            url     : '{{route('remove_categories')}}',
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                company    : '{{$company->id}}',
                                categories : categories
                            },
                            success : function(response){
                                $('#custom-checkable1').treeview('getChecked').forEach(function(currentNode, key){
                                    $('#custom-checkable').treeview('uncheckNode', currentNode['nodeId']);
                                });
                                $('#custom-checkable1').treeview('collapseAll', {silent : true});
                                var data = {};
                                if(response.categories.length > 0){
                                    data = response.categories;
                                }
                                buildTree(data);
                                addButton.attr('disabled', false);
                                removeButton.attr('disabled', false);
                                progress.hide();
                            },
                            error   : function(){
                                alert('Системная ошибка');
                                addButton.attr('disabled', false);
                                removeButton.attr('disabled', false);
                                progress.hide();
                            }
                        });
                    }
                }

            });
            buildTree(<?=$category?>);
        });


        function buildTree(data){
            $('#custom-checkable1').treeview({
                data            : data,
                showCheckbox    : true,
                enableLinks     : false,
                onNodeChecked   : function(event, node){
                    if(node['nodes'].length > 0){
                            node['nodes'].forEach(function(currentNode, key){
                                $('#custom-checkable1').treeview('checkNode', currentNode['nodeId']);
                            });
                    }
                },
                onNodeUnchecked : function(event, node){
                    if(node['nodes'].length > 0){
                            node['nodes'].forEach(function(currentNode, key){
                                $('#custom-checkable1').treeview('uncheckNode', currentNode['nodeId']);
                            });
                    }
                }
            }).treeview('collapseAll');
        }

        /*var buttonRedirectMyScore = document.querySelector('.btn-primary');
        buttonRedirectMyScore.addEventListener('click', RedirectMyScore);

        function RedirectMyScore(){
            window.location.href = "http://cuba.loc/product-editor/"+'{{$company->id}}';
        }*/

    </script>

@endsection