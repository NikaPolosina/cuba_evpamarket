
{{ Form::open(array(  'method' => 'post', 'url' => '/company-create-discount/'.$company->id , 'class' => 'form-inline', 'data-id' =>(isset($item->id)) ? $item->id : null )) }}
{!! csrf_field() !!}

{!! Form::hidden('id', (isset($item->id)) ? $item->id : null, ['class' => 'form-control', 'required' => 'required',  'min' => '0']) !!}



    <div class="form-group">
        <p>Со скольки (руб): </p>
        <?php
            $data['from']='';
            $data['percent']='';
            $err = false;
            if(isset($item)){
                    $data['from'] = $item->from;
                    $data['percent'] = $item->percent;

                if($errors->count() && old('id') == $item->id){
                    $err = true;
                    $data['from'] = old('from');
                    $data['percent'] = old('percent');
                }
            }else{
                if($errors->count() && !old('id')){
                    $err = true;
                    $data['from'] = old('from');
                    $data['percent'] = old('percent');
                }
            }
        ?>


        @if(isset($max_value) && $max_value['from'])
            <input type="number" name="from" value=""  class = 'form-control' min="{{$max_value['from']}}" required>
        @else
            <input type="number" name="from" value="<?=$data['from']?>"  class = 'form-control' min="0" required>
        @endif

        @if ($err  && $errors->has('from'))
            <div>
            <span class="help-block">
                <strong>{{ $errors->first('from') }}</strong>
            </span>
            </div>
        @endif
    </div>

    <div class="form-group">
        <p>Скидка(%) </p>
        @if(isset($max_value) && $max_value['percent'])
            <input type="number" name="percent" value=""  class = 'form-control percent' min="{{$max_value['percent']}}" max="99" required>
        @else
            <input type="number" name="percent" value="<?=$data['percent']?>"  class = 'form-control percent' min="1" max="99" required>
        @endif

        @if ($err  && $errors->has('percent'))
             <div>
                <span class="help-block">
                 <strong>{{ $errors->first('percent')}}</strong>
                </span>
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary bt_t"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>
    @if(isset($item->id))
       <button type="button" data-id-company="{{$company->id}}" data-id-item="{{$item->id}}" class="btn btn-danger bt_t tut"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
    @endif
{{ Form::close() }}








<style>
    .form-group>p{
        font-size: 14px;
    }
    .form-control{
        color: #4EA1DF;
    }
    .percent{
        color: #f4645f;
    }
    .bt_t{
        margin: 25px 0 0 10px;
    }
    .help-block{
        color: red;
    }
</style>