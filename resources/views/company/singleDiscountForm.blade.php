
{{ Form::open(array(  'method' => 'post', 'url' => '/company-create-discount/'.$company->id , 'class' => 'form-inline' )) }}
{!! csrf_field() !!}

{!! Form::hidden('id', $item->id ?? null, ['class' => 'form-control', 'required' => 'required',  'min' => '0']) !!}



    <div class="form-group">
        <p>Со скольки (руб): </p>
        <?php
            $data['from']='';
            $data['to']='';
            $data['percent']='';
            $err = false;
            if(isset($item)){
                    $data['from'] = $item->from;
                    $data['to'] = $item->to;
                    $data['percent'] = $item->percent;

                if($errors->count() && old('id') == $item->id){
                    $err = true;
                    $data['from'] = old('from');
                    $data['to'] = old('to');
                    $data['percent'] = old('percent');
                }
            }else{
                if($errors->count() && !old('id')){
                    $err = true;
                    $data['from'] = old('from');
                    $data['to'] = old('to');
                    $data['percent'] = old('percent');
                }
            }
        ?>

        <input type="number" name="from" value="<?=$data['from']?>"  class = 'form-control' min="0" required>
        @if ($err  && $errors->has('from'))
            <div>
            <span class="help-block">
                <strong>{{ $errors->first('from') }}</strong>
            </span>
            </div>
        @endif
    </div>
    <div class="form-group">
        <p>До скольки (руб): </p>
        <input type="number" name="to" value="<?=$data['to']?>"  class = 'form-control' min="1" required>
        @if ($err  && $errors->has('to'))
            <div>
                <span class="help-block">
                     <strong>{{ $errors->first('to') }}</strong>
                </span>
            </div>
        @endif
    </div>
    <div class="form-group">
        <p>Скидка(%) </p>
        <input type="number" name="percent" value="<?=$data['percent']?>"  class = 'form-control percent' min="1" max="99">
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
        <a href="/company-destroy-discount/{{$company->id}}/{{$item->id}}"> <button type="button"  class="btn btn-danger bt_t"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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