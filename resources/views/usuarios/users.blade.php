@extends('adminlte::page')

@section('htmlheader_title')
    Contole Acesso - Usuário
@endsection


@section('main-content')
	<div class="row">
		<div class="col-md-12">

			<div class="card card-outline card-success">
                <div class="card-header with-border">
                    <h3 class="card-title">Usuários</h3>                        
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                     @if(session('success'))
                        <p class="alert-success">
                            {{session('success')}}
                        </p>
                    @endif

                    <table id="users" class="table table-striped table-bordered dt-responsive" cellpadding="0" width="100%" >    
                        <thead>
                            <tr>
                                <th>ID</th>            
                                <th>nome</th>            
                                <th>username</th>                                                                               
                                <th>Ações</th>
                            </tr>
                        </thead>
                        
                    </table>
                    <!--@ can('usuario.criar')
                        <a href="{{url('/admin/users/create')}}" class="btn btn-success">Inserir</a>  
                    @ endcan-->
                </div>
            </div>
                <!-- /.card-body -->
        </div>

	</div>
@endsection


@section('main-scripts')
<script>
    $(document).ready(function(){
    $('#users').DataTable( {
        "language": {
            "url" : '/lang/pt_BR/dataTable.pt_BR.json'                      
        },
        "order": [0, 'desc'],
        "responsive": true,
        "processing": true,
        "serverSide": true,        
        "ajax": { 
            'url': "usuarios/get_datatableUsuarios",
            'type': 'POST',
            'data':{ _token: "{{csrf_token()}}"},

        }, 
        "columns":[
            {data: 'id', name: 'users.id'},            
            {data: 'name', name: 'users.name'},                           
            {data: 'username', name: 'users.username'},                                  
            {data: 'action', orderable: false, searchable: false, className: "acoes"}
        ]
    });
});

</script>
@endsection