<div class="col-md-12">
    <div class="form-group">
        {!! Form::label('nome', 'Nome do papel') !!}
        {!! Form::text('nome', null,['class'=>'form-control', 'required']) !!}
        @error('nome')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        {!! Form::label('descricao', 'Descricao') !!}
        {!! Form::text('descricao', null,['class'=>'form-control', 'required']) !!}
        @error('descricao')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        {!! Form::button('<i class="fa fa-floppy-o"></i> Salvar', ['type'=>'submit', 'class'=>'btn btn-primary']) !!}
        {!! Html::decode(link_to_route('papeis.index', '<i class="fa fa-reply"></i> Cancelar', null, ['class'=> 'btn btn-primary'])) !!}
    </div>
</div>