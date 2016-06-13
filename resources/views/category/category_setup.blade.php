@extends('...layouts.app')

@section('content')

<div class="col-sm-10 col-md-offset-1" style="border: solid 1px red">

    <div class="company_tile_category">
        <h2 style="text-align: center">redactor categorii magazina</h2>
        <h2>Магазин {{$company->company_name}}</h2>
        <hr/>
    </div>

    <div class="col-sm-10 col-md-offset-1" >

        <div class="col-sm-6">
            <div class="category_system">
                <h4>Все категории</h4>
                <div id="custom-checkable1" class="">

                </div>
            </div>
        </div>


        <div class="col-sm-6">
            <div class="category_user">
                <h4>Kатегории magazina</h4>
                <div id="custom-checkable" class="">

                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-12">
        <hr/>
        <div class="footer_button" style="float: right;">
            <button type="button" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default">Cansel</button>
        </div>
    </div>


</div>

<script>

        var data = <?=json_encode($categories) ?> ;

                    $('#custom-checkable1').treeview({
                        data            : data,
                        showCheckbox    : true,
                        enableLinks     : false,
                        onNodeChecked   : function(event, node){
                            a.show();
                            ul.append('<li><input checked="checked" type="checkbox" value="' + node.id + '"/>' + node.text + '</li>');
                        },
                        onNodeUnchecked : function(event, node){
                            ul.find('input[value="' + node.id + '"]').parent().remove();
                            if(ul.find('input').length < 1){
                                a.hide();
                            }
                            console.log(node.text + ' was unchecked');
                        }
                    }).treeview('collapseAll');




var data = <?=$category?>;

        $('#custom-checkable').treeview({
            data            : data,
            showCheckbox    : true,
            enableLinks     : false,
            onNodeChecked   : function(event, node){

                $('#custom-checkable').treeview('selectNode', node.nodeId);

                /* $('.addProductCategory').hide();//ertyuiosdfghkwertyuierty*/
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


</script>

@endsection