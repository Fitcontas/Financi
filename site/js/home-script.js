'use strict';

var AppFinanci = angular.module('Village', [ 'ngAnimate', 'ngResource', 'ngRoute', 'angular-loading-bar', 'ngMask']);

AppFinanci.run(function($rootScope) {

  $rootScope.images = [
      'img/slide-1.jpg',
      'img/slide-2.jpg',
      'img/slide-3.jpg',
      'img/slide-4.jpg'
  ];

  $rootScope.backstretch = function() {
      $(".index").backstretch($rootScope.images, { duration: 4000, fade: 'slow' });
  };

  $rootScope.backstretch();
});

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
      controller: 'LocalizacaoCtrl'
  })

  .when('/contato', {
      reloadOnSearch: false,
      templateUrl: 'views/fale-conosco.html',
      controller: 'ContatoCtrl'
  })

  $('#copyright').css({
    top: $(window).height() - 100,
  })

});

AppFinanci.controller('SlideCtrl', function($scope, $location) {

  $scope.images = [
      'img/slide-1.jpg',
      'img/slide-2.jpg',
      'img/slide-3.jpg',
      'img/slide-4.jpg'
  ];

  $scope.titulos = {
    1:'Avenida Comercial',
    2:'Infraestrutura Completa',
    3:'Áreas Públicas',
    4:'Áreas Públicas'
  };

  //$scope.slide_atual = 1;
  $scope.titulo_atual = '';

  $scope.slide = function(n) {
    $('.modal').modal('hide');
    $scope.slide_atual = n;
    $scope.titulo_atual = $scope.titulos[n];
    //$scope.apply();
    //$.backstretch("destroy", true);
    //$.backstretch('img/slide-'+n+'.jpg');
    $('#modal-slide').modal({
        show: true,
        backdrop: 'static'
    });
  }

  $scope.video = function() {
    $('#modal-video').modal({
        show: true,
        backdrop: 'static'
    });
  }

  $scope.mudaImagem = function(ctrl) {
    console.log($scope.slide_atual);

    if(ctrl) {

      if(!$scope.titulos[$scope.slide_atual + 1]) {
        $scope.slide_atual = 1;
        $scope.titulo_atual = $scope.titulos[1];
        return true;
      }

      $scope.slide_atual = $scope.slide_atual + 1;
      $scope.titulo_atual = $scope.titulos[$scope.slide_atual];
    } else {

      if(!$scope.titulos[$scope.slide_atual - 1]) {
        $scope.slide_atual = 4;
        $scope.titulo_atual = $scope.titulos[4];
        return true;
      }

      $scope.slide_atual = $scope.slide_atual - 1;
      $scope.titulo_atual = $scope.titulos[$scope.slide_atual];
    }
  }

  
})

.controller('LocalizacaoCtrl', function($scope, $http, $window) {
  $('#modal-localizacao').modal({
    show: true,
    backdrop: 'static'
  }).on('hidden.bs.modal', function() {
     $window.location = '#/'
  });
})

.controller('ContatoCtrl', function($scope, $http, $window) {

  $('#modal-contato').modal({
    show: true,
    backdrop: 'static'
  }).on('hidden.bs.modal', function() {
     $window.location = '#/'
  });

  $scope.contato = {
    nome: '',
    email: '',
    telefone:  '',
    assunto: ''
  };

  $scope.enviarContato = function() {
    alert('teste');
    var contato = $scope.contato;
    if(contato.nome == '' || contato.email == '' || contato.telefone == '' || contato.assunto == '') {
      $scope.alert_modal_titulo = 'Error no Formulário'
      $scope.alert_modal_texto = 'Por favor preencha todos os campos do formulário de contato.';
      $('#contato-alert').modal('show');
      return false;
    }

    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if(!filter.test(contato.email)) {
      $scope.alert_modal_titulo = 'Error no Formulário'
      $scope.alert_modal_texto = 'Por favor informe um e-mail válido.';
      $('#contato-alert').modal('show');
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
          $('#contato-alert').modal('show');
          $scope.contato = {};
        } else {
          $scope.alert_modal_titulo = 'Erro!'
          $scope.alert_modal_texto = 'Houve um erro ao tentar enviar sua mensagem, por favor tente mais tarde.';
          $('#contato-alert').modal('show');
        }
      }).error(function(data, status) {
        $scope.alert_modal_titulo = 'Erro!'
        $scope.alert_modal_texto = 'Houve um erro ao tentar enviar sua mensagem, por favor tente mais tarde.';
        $('#contato-alert').modal('show');
      });

  }
})