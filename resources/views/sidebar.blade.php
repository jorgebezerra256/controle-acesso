@if(Auth::user()->can('usuario.listar') || Auth::user()->can('papel.criar') || Auth::user()->can('papel.listar') || Auth::user()->can('permissao.listar') || Auth::user()->can('permissao.criar'))
<li id="side-bar-acesso" class="nav-item">
    <a class="nav-link" href="#">
        <i class="nav-icon fa fa-lock"></i>
        <p>
            Controle Acesso
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('usuario.listar')
        <li id="side-bar-usuarios" class="nav-item">
            <a class="nav-link" href="#">
                <i class='nav-icon fa fa-user-alt'></i>
                <p>
                    Usuários
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <p>Listar</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        @if(Auth::user()->can('permissao.listar') || Auth::user()->can('permissao.criar'))
        <li id="side-bar-permissoes" class="nav-item">
            <a class="nav-link" href="#">
                <i class='nav-icon fa fa-unlock'></i>
                <p>
                    Permissões
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can('permissao.listar')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissoes.index') }}">
                        <p>Listar</p>
                    </a>
                </li>
                @endcan
                @can('permissao.criar')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissoes.create') }}">
                        <p>Inserir</p>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('papel.criar') || Auth::user()->can('papel.listar'))
        <li id="side-bar-papeis" class="nav-item">
            <a class="nav-link" href="#">
                <i class='nav-icon fa fa-unlock-alt'></i>
                <p>
                    Papéis
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can('papel.listar')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('papeis.index') }}">
                        <p>Listar</p>
                    </a>
                </li>
                @endcan
                @can('papel.criar')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('papeis.create') }}">
                        <p>Inserir</p>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
    </ul>
</li>
@endif