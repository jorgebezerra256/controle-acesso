@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Papel
@endsection


@section('main-content')	
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header with-border">
                    <h3 class="card-title">Permissão x Papel</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">                     
                     {!! Form::open(array('route' => ['papeis.permissao.store', $papel->id])) !!}
    
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('permissao_id', 'Permissão') !!}        
                                {!! Form::select('permissao_id',  \Arr::pluck($permissoes, 'nome', 'id'), '',['class'=>'form-control']) !!}
                                @error('permissao_id')
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
                    <br/>
                    <div class="col-md-12">
                        <h3>Permissões para o papel '{{ $papel->nome }}'</h3>
                    </div>
                    <table id="permissoesPapel" class="table table-striped table-bordered dt-responsive" cellpadding="0" width="100%" >    
                        <thead>
                            <tr>
                                <th>id</th>                                                
                                <th>Permissão</th>            
                                <th>Descricão</th>                                                            
                                <th>Ação</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

		</div>
	</div>	
@endsection

@section('main-scripts')
<script>
    $('#permissao_id').select2();

    $(document).ready(function(){
    $('#permissoesPapel').DataTable( {
        "language": {
            "url" : '/lang/pt_BR/dataTable.pt_BR.json'                      
        },
        "order": [0, 'desc'],
        "responsive": true,
        "processing": true,
        "serverSide": true,       
        "ajax": { 
            'url': "/admin/papeis/get_datatablePapelPermissao/{{$papel->id}}",
            'type': 'POST',
            'data':{ _token: "{{csrf_token()}}"},

        }, 
        "columns":[                     
            {data: 'id', name: 'permissoes.id'},    
            {data: 'nome', name: 'permissoes.nome'},            
            {data: 'descricao', name: 'permissoes.descricao'},
            {data: 'action', orderable: false, searchable: false, className: "acoes"}
        ]
    });
});

</script>
@endsection