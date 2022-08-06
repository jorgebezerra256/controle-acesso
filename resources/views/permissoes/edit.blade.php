@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Permissão
@endsection


@section('main-content')	
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Editar permissão</h3>                       
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {!! Form::model($permissao, array('route' => ['permissoes.update', $permissao->id], 'method'=> 'put')) !!}

                        @include('ca::permissoes._fields')

                    {!! Form::close() !!}
                </div>
                <!-- /.card-body -->
            </div>

		</div>
	</div>
@endsection
