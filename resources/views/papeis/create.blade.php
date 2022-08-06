@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Papel
@endsection


@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Inserir Papel</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {!! Form::open(array('route' => 'papeis.store')) !!}
                
                @include('ca::papeis._fields')

                {!! Form::close() !!}
            </div>
            <!-- /.card-body -->
        </div>

    </div>
</div>
@endsection