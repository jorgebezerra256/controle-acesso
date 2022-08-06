@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Permissão
@endsection


@section('main-content')
<div class="row">
    <div class="col-md-12">

        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Inserir Permissão</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if(session('success'))
                <p class="alert-success">
                    {{session('success')}}
                </p>
                @endif

                {!! Form::open(array('route' => 'permissoes.store')) !!}

                @include('ca::permissoes._fields')

                {!! Form::close() !!}
            </div>
            <!-- /.card-body -->
        </div>

    </div>
</div>
@endsection