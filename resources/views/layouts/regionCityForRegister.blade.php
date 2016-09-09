{{----------------------------------------------------------------------------------------------------------------------------}}
<div  class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Регион</label>
    <div class="col-md-6">
        <div class="form-group" style="margin: 0px">
            <select class="chosen-select" name="region" id="sel1">
                <option value="">Выбирите регион</option>
                @foreach($region as $value)
                    <option value="{{$value->id_region}}">{{$value->title}}</option>
                @endforeach
            </select>

            @if ($errors->has('region'))
                <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
            @endif
        </div>
    </div>
</div>


<script>
    var city_id = '';
</script>

@if(old('city'))
    <script>
        city_id = '{{old('city')}}';
    </script>
@endif


<script>
    $(document).ready(function(){
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});


        $('#sel1').on('change', function(){
          //  console.log($(this).val());
            if($(this).val().length){
                $.ajax({
                    type: "GET",
                    url: "/get-city-by-region/"+$(this).val(),
                    data: '',
                    success: function(data){
                        $('#sel2_holder').show();
                        var selector = $('#sel2');

                        selector.html('');

                        $.each(data, function(index, value) {

                            selector.append('<option value="'+value.id_cities+'">'+value.title_cities+'</option>');
                        });

                        $('.chosen').chosen({no_results_text: "Oops, nothing found!"}).trigger("chosen:updated")
                        if(city_id.length > 0){
                            $('.chosen').val(city_id);



                            $('.chosen').trigger("chosen:updated");
                            city_id = false;
                        }
                    }
                });
            }


        });
    });


</script>
{{----------------------------------------------------------------------------------------------------------------------------}}
<div style="display: none" id="sel2_holder" class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Город</label>
    <div class="col-md-6">
        <div {{--class="form-group"--}}>
            <select class="chosen"  name="city" id="sel2">
                {{-- @foreach($city as $value)
                     <option>{{$value->title_cities}}</option>
                 @endforeach--}}
            </select>
        </div>
    </div>
</div>

{{----------------------------------------------------------------------------------------------------------------------------}}