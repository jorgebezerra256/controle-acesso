@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Permissão
@endsection


@section('main-content')	
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Permissões</h3>                        
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session('success'))
                        <p class="alert alert-success">
                            {{session('success')}}
                        </p>
                    @endif
                    @if(session('error'))
                        <p class="alert alert-danger">
                            {{session('error')}}
                        </p>
                    @endif
                    <table id="permissoes" class="table table-striped table-bordered dt-responsive" cellpadding="0" width="100%">    
                        <thead>
                            <tr>
                                <th>id</th>                                                
                                <th>Permissão</th>            
                                <th>Descrição</th>                                                            
                                <th>Ação</th>
                            </tr>
                        </thead>
                        
                    </table>
                    @can('permissao.criar')
                        <a href="{{url('/admin/permissoes/create')}}" class="btn btn-success"><i class="fa fa-plus" ></i> Inserir</a>  
                    @endcan
                </div>
                <!-- /.card-body -->
            </div>

		</div>
	</div>
@endsection


@section('main-scripts')
<script>
    $(document).ready(function(){
    $('#permissoes').DataTable( {
        "language": {
            "url" : '/lang/pt_BR/dataTable.pt_BR.json'                      
        },
        "order": [0, 'desc'],
        "responsive": true,
        "processing": true,
        "serverSide": true,        
        "ajax": { 
            'url': "/admin/permissoes/get_datatable",
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