@extends('adminlte::page')

@section('htmlheader_title')
	Contole Acesso - Papel Usuário
@endsection


@section('main-content')
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header with-border">
                    <h3 class="card-title">Papéis para o usuário {{ $usuario->name }}</h3>                        
                </div>
                <!-- /.card-header -->
                <div class="card-body">                    
                    {!! Form::open(array('route' => ['users.papel.store', $usuario->id])) !!}
    
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('papel_id', 'Papel') !!}        
                                {!! Form::select('papel_id',  Illuminate\Support\Arr::pluck($papeis, 'nome', 'id'), '',['class'=>'form-control']) !!}
                                @error('papel_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::button('Adicionar', ['type'=>'submit', 'class'=>'btn btn-primary']) !!}                            
                            </div>
                        </div>   

                    {!! Form::close() !!}
                    
                    <div class="col-md-12">
                    <table id="papeisUser" class="table table-striped table-bordered dt-responsive" cellpadding="0" width="100%">    
                        <thead>
                            <tr>
                                <th>id</th>                                                
                                <th>Papel</th>            
                                <th>Descricão</th>                                                            
                                <th>Ação</th>
                            </tr>
                        </thead>                            
                    </table>  
                    </div>                      
                </div>
                <!-- /.card-body -->
            </div>

		</div>
	</div>
@endsection


@section('main-scripts')
<script>

    $('#papel_id').select2();

    $(document).ready(function(){
    $('#papeisUser').DataTable( {
        "language": {
            "url" : '/lang/pt_BR/dataTable.pt_BR.json'                      
        },
        "responsive": true,
        "processing": true,
        "serverSide": true,        
        "ajax": { 
            'url': "/admin/usuarios/get_datatableUsuarioPapel/{{ $usuario->id }}",
            'type': 'POST',
            'data':{ _token: "{{csrf_token()}}"},

        }, 
        "columns":[                     
            {data: 'id', name: 'papeis.id'},    
            {data: 'nome', name: 'papeis.nome'},            
            {data: 'descricao', name: 'papeis.descricao'},
            {data: 'action', orderable: false, searchable: false, className: "acoes"}
        ]
    });
});

</script>
@endsection