# Controle Acesso
Projeto PHP baseado em lavarel para permissionamento de sistemas

# Requisitos
Requisitos para usar o pacote

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)

# Instalação
composer require jorgebezerra/controle_acesso

# Menu de acesso
## Insira o menu de acesso as funcionalidades.
Em uma view para adicionar o menu chame-o da seguinte foram:
```bash
ca::sidebar
```

# Uso
Cadaste as permissões e os papeis, atribua permissões a papeis.

Verificar se usuário autenticado possui permissão:
```bash
checkPermissao('papel.delpermissao');
```