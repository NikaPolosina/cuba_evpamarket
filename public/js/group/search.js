$(document).ready(function(){
    var selectorScope                                  = {};
    selectorScope['advanced_search_button']            = $('.advanced_search_button');
    selectorScope['advanced_search_block']             = $('.advanced_search_block');
    selectorScope['advanced_search_result']            = $('.advanced_search_result');
    selectorScope['advanced_search_result_data']       = $('.advanced_search_result_data');
    selectorScope['advanced_search_action_button']     = $('.advanced_search_action_button');
    selectorScope['advanced_search_progress']          = $('.advanced_search_progress');
    selectorScope['advanced_search_error']             = $('.advanced_search_error');
    selectorScope['advanced_search_result_txt']             = $('.advanced_search_result_txt');

    var ageFrom = $('.advanced_search_age_from');
    var ageTo = $('.advanced_search_age_to');

    var error                                          = false;
    var current;
    var data                                           = {};
    var region;
    var city;

    $(selectorScope['advanced_search_button']).on('click', function(){
        selectorScope['advanced_search_block'].toggle();
        selectorScope['advanced_search_result'].hide();
        selectorScope['advanced_search_result_data'].html('');
        region = '';
        city = '';


        selectorScope['advanced_search_action_button'].on('click', function(){
            error = false;
            selectorScope['advanced_search_block'].find('input').each(function(index, item){
                event.preventDefault();
                if($(item).attr('required') == 'required'){
                    if($(item).val() == ''){
                        error = true;
                        item.focus();
                        return false;
                    }
                }
            });
            if(error){
                return false;
            }
            current = null;
            data    = {};


            data['name'] = $('.advanced_search_name').val();
            data['surname'] = $('.advanced_search_surname').val();
            data['age_from'] = ageFrom.val();
            data['age_to'] = ageTo.val();
            data['gender'] = '';

            $('.advanced_search_gender').each(function(index, item){
                if($(item).is(':checked')){
                    data['gender'] = $(item).val();
                }
            });

            data['region'] = '';
            data['city'] = '';

            // todo: add  region
            region = selectorScope['advanced_search_block'].find('#sel1');
            if(region.length){
                data['region'] = region.val();
            }

            city = selectorScope['advanced_search_block'].find('#sel2');
            if(city.length){
                data['city'] = city.val();
            }




            selectorScope['advanced_search_progress'].show();
            $.ajax({
                type    : "POST",
                url     : advancedUserSearchUrl,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {
                    params : data
                },
                success : function(response){
                    selectorScope['advanced_search_progress'].hide();
                    selectorScope['advanced_search_result_data'].html('');
                    selectorScope['advanced_search_result'].show();

                    if(response.data.length > 0){
                        selectorScope['advanced_search_result_txt'].html('По Вашему запросу было найдено');
                        current = '';
                        for(var index in response.data){
                            current = response.data[index];
                            selectorScope['advanced_search_result_data'].append('' +
                                '<div class="single_people_css single_person_holder" style="display: table; width: 100%">'+
                                '<div style="display: table-cell; vertical-align: middle">'+
                                '<div class="css_peo" style="display: inline-block">'+
                                '<div class="sercl_img_css">'+
                                '<img src="'+current.get_user_information.avatar+'" alt="logo">'+
                                '</div>'+
                                '</div>'+
                                '<div class="css_peo">'+
                                '<p style="display: inline-block;">'+current.get_user_information.name+'   '+current.get_user_information.surname+'</p>'+
                                '</div>'+
                                '<div class="css_peo po_button">'+
                                '<button class="btn-primary invite_to_group_search" data-user="'+current.id+'" data-group="'+currentGroup+'">Пригласить</button>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                            '');
                        }
                    }else{
                        selectorScope['advanced_search_result_txt'].html('По Вашему запросу ничего не найдено');
                    }

                    },
                error   : function(response){
                    selectorScope['advanced_search_progress'].hide();
                    selectorScope['advanced_search_error'].show();
                    selectorScope['advanced_search_result'].hide();
                    setTimeout(function(){
                        selectorScope['advanced_search_error'].hide(1000);
                    }, 2000);
                }
            });
        });
    });


    ageFrom.on('change', function(){
        var currentVal = $(this).val();
        ageTo.find('option').each(function(){
            if($(this).val() && $(this).val() <= currentVal){
                $(this).attr('disabled', true);
                $(this).hide();
            }else{
                $(this).attr('disabled', false);
                $(this).show();
            }
        });
    });

    ageTo.on('change', function(){
        var currentVal = $(this).val();
        ageFrom.find('option').each(function(){
            if($(this).val() && $(this).val() >= currentVal){
                $(this).attr('disabled', true);
                $(this).hide();
            }else{
                $(this).attr('disabled', false);
                $(this).show();
            }
        });
    });



});