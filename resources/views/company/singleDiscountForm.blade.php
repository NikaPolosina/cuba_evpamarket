{{ Form::open(array(  'method' => 'post', 'url' => '/company-create-discount/'.$company->id , 'class' => 'form-inline' )) }}
{!! csrf_field() !!}

{!! Form::hidden('id', $item->id ?? null, ['class' => 'form-control', 'required' => 'required',  'min' => '0']) !!}
    <div class="form-group">
        <p>Со скольки (руб): </p>
        {!! Form::number('from', $item->from ?? null, ['class' => 'form-control', 'required' => 'required',  'min' => '0']) !!}
    </div>
    <div class="form-group">
        <p>До скольки (руб): </p>
        {!! Form::number('to', $item->to ?? null, ['class' => 'form-control', 'required' => 'required',  'min' => '0']) !!}
    </div>
    <div class="form-group">
        <p>Скидка(%) </p>
        {!! Form::number('percent', $item->percent ?? null, ['class' => 'form-control percent', 'required' => 'required',  'min' => '0', 'max' => '99']) !!}

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
</style>