'use strict';

var AppFinanci = angular.module('Village', [ 'ngAnimate', 'ngResource', 'ngRoute', 'angular-loading-bar', 'ngMask']);

// configure our routes
AppFinanci.config(function($routeProvider, $locationProvider) {

  //$locationProvider.html5Mode(true).hashPrefix('!');

  $routeProvider

  // route for the home page
  .when('/', {
      reloadOnSearch: false,
      templateUrl : 'views/home.html',
      controller  : 'SlideCtrl'
  })

  .when('/localizacao', {
      reloadOnSearch: false,
      templateUrl: 'views/localizacao.html',
      //controller: 'LocalizacaoCtrl'
  })

  .when('/fale-conosco', {
      reloadOnSearch: false,
      templateUrl: 'views/fale-conosco.html',
      controller: 'ContatoCtrl'
  })

});

AppFinanci.controller('SlideCtrl', function($scope, $location) {
    
  $.backstretch("destroy", true);

  $scope.images = [
      'img/slide-1.jpg',
      'img/slide-2.jpg',
      'img/slide-3.jpg',
      'img/slide-4.jpg'
  ];

  $scope.slide = function(n) {
      $.backstretch("destroy", true);
      $.backstretch('img/slide-'+n+'.jpg');
  }

  $scope.backstretch = function() {
      $(".index").backstretch($scope.images, { duration: 4000, fade: 'slow' });
  }

  $scope.backstretch();
})

.controller('ContatoCtrl', function($scope, $http) {

  $scope.contato = {
    nome: '',
    email: '',
    telefone:  '',
    assunto: ''
  };

  $scope.enviarContato = function() {
    var contato = $scope.contato;
    if(contato.nome == '' || contato.email == '' || contato.telefone == '' || contato.assunto == '') {
      $scope.alert_modal_titulo = 'Error no Formulário'
      $scope.alert_modal_texto = 'Por favor preencha todos os campos do formulário de contato.';
      $('.modal').modal('show');
      return false;
    }

    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if(!filter.test(contato.email)) {
      $scope.alert_modal_titulo = 'Error no Formulário'
      $scope.alert_modal_texto = 'Por favor informe um e-mail válido.';
      $('.modal').modal('show');
      return false;
    }

    $http({
        method: 'POST',
        url: '/contato',
        data: contato
      }).success(function(data, status) {
        if(data.success == 2) {
          $scope.alert_modal_titulo = 'Parábens!'
          $scope.alert_modal_texto = 'Sua mensagem foi enviada com sucesso.';
          $('.modal').modal('show');
          $scope.contato = {};
        } else {
          $scope.alert_modal_titulo = 'Erro!'
          $scope.alert_modal_texto = 'Houve um erro ao tentar enviar sua mensagem, por favor tente mais tarde.';
          $('.modal').modal('show');
        }
      }).error(function(data, status) {
        $scope.alert_modal_titulo = 'Erro!'
        $scope.alert_modal_texto = 'Houve um erro ao tentar enviar sua mensagem, por favor tente mais tarde.';
        $('.modal').modal('show');
      });

  }
})

.directive('isActiveNav', [ '$location', function($location) {
  return {
   restrict: 'A',
   link: function(scope, element) {
     scope.location = $location;
     scope.$watch('location.path()', function(currentPath) {
        if('#' + currentPath === element[0].attributes['href'].nodeValue) {
          element.parent().addClass('active');
        } else {
          element.parent().removeClass('active');
        }
     });
   }
 };
}]);