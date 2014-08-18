AppFinanci.factory('Cidades', function($resource) {
    return $resource('/cidades/:uf');
})

.factory('ClientesBusca', function($resource) {
    return $resource('/cliente/busca/:id', {'id':'@id'});
})

.factory('Clientes', function($resource) {
    return $resource('/cliente/all/:id', {'id':'@id'});
})

.factory('Usuarios', function($resource) {
    return $resource('/usuario/all/:id', {'id':'@id'});
})

.factory('UsuarioNovo', function($resource) {
    return $resource('/usuario/novo/:id', {'id':'@id'});
})

.factory('Empreendimentos', function($resource) {
    return $resource('/empreendimento/all/:id', {'id':'@id'});
})

.factory('EmpreendimentoNovo', function($resource) {
    return $resource('/empreendimento/novo/:id', {'id':'@id'});
})

.factory('Corretores', function($resource) {
    return $resource('/corretores');
})

.factory('Grupos', function($resource) {
    return $resource('/usuario/grupos/:id', {'id':'@id'});
})

.factory('Estados', function($resource) {
    return $resource('/estados');
})