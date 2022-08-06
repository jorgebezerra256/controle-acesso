@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Papel
@endsection


@section('main-content')	
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Papéis</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session('success'))
                        <p class="alert-success">
                            {{session('success')}}
                        </p>
                    @endif

                    <!-- class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100% -->
                    <table id="papeis" class="table table-striped table-bordered dt-responsive" cellpadding="0" width="100%">    
                        <thead>
                            <tr>
                                <th>ID</th>            
                                <th>Nome</th>            
                                <th>Descrição</th>                                                                               
                                <th>Ações</th>
                            </tr>
                        </thead>
                        
                    </table>
                    <a href="{{url('/admin/papeis/create')}}" class="btn btn-success"><i class="fa fa-plus" ></i> Inserir</a>  
                </div>
                <!-- /.card-body -->
            </div>

		</div>
	</div>	
@endsection


@section('main-scripts')
<script>
    $(document).ready(function(){
    $('#papeis').DataTable( {
        "language": {
            "url" : '/lang/pt_BR/dataTable.pt_BR.json'                      
        },
        "order": [0, 'desc'],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": { 
            'url': "papeis/get_datatablePapeis",
            'type': 'POST',
            'data':{ _token: "{{csrf_token()}}"},

        }, 
        "columns":[
            {data: 'id', name: 'papeis.id'},            
            {data: 'nome', name: 'papeis.nome'},                           
            {data: 'descricao', name: 'papeis.descricao'},                                  
            {data: 'action', orderable: false, searchable: false, className: "acoes", width: '180px'}
        ]
    });
});

</script>
@endsection