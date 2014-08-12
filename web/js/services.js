AppFinanci.factory('Cidades', function($resource) {
    return $resource('/cidades/:uf');
})

.factory('Usuarios', function($resource) {
    return $resource('/usuario/all/:id', {'id':'@id'});
})

.factory('UsuarioNovo', function($resource) {
    return $resource('/usuario/novo/:id', {'id':'@id'});
});