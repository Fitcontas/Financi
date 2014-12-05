AppFinanci.directive("passwordVerify", function() {
   return {
      require: "ngModel",
      scope: {
        passwordVerify: '='
      },
      link: function(scope, element, attrs, ctrl) {
        scope.$watch(function() {
            var combined;

            if (scope.passwordVerify || ctrl.$viewValue) {
               combined = scope.passwordVerify + '_' + ctrl.$viewValue; 
            }                    
            return combined;
        }, function(value) {
            if (value) {
                ctrl.$parsers.unshift(function(viewValue) {
                    var origin = scope.passwordVerify;
                    if (origin !== viewValue) {
                        ctrl.$setValidity("passwordVerify", false);
                        return undefined;
                    } else {
                        ctrl.$setValidity("passwordVerify", true);
                        return viewValue;
                    }
                });
            }
        });
     }
   };
})

.directive('defaultActionsButtons', function() {
  return {
        scope: true,
        replace: 'true',
        restrict: 'AE',
        templateUrl: 'html-directives/default-actions-buttons.html'
  };
})

.directive('defaultSearchField', function() {
  return {
        scope: true,
        replace: 'true',
        restrict: 'AE',
        templateUrl: 'html-directives/default-search-field.html'
  };
})

.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if(event.which === 13) {
                scope.$apply(function(){
                    scope.$eval(attrs.ngEnter, {'event': event});
                });

                event.preventDefault();
            }
        });
    };
})

.directive('ngMoney', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {
        element.maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, allowZero:true});
      }
    };
})

.directive('ngCheckTest', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {
        $(element).change(function() {  
          if($(this).is(':checked')){
            $(this).closest('tr').addClass('on');
          }else{
              $(this).closest('tr').removeClass('on');
          }
        })
      }
    };
})

.directive('ngCheckAllTest', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {
        $(element).change(function() {
          if($(this).is(':checked')){
            $(this).closest('table').find('tbody tr').addClass('on');
          }else{
            $(this).closest('table').find('tbody tr').removeClass('on');
          }
        })
      }
    };
})

.directive('ngSort', function() {
    return {
      link: function($scope, element, attrs, controller) {
        element.click(function() {
          $scope.start(null, attrs.column, attrs.sort);
          $('.sorting_desc, .sorting_asc').removeClass('sorting_asc').removeClass('sorting_desc').addClass('sorting');
          element.removeClass('sorting').removeClass('sorting_asc').removeClass('sorting_desc');
          
          if(attrs.sort == 'asc') {
            attrs.sort = 'desc';
            element.addClass('sorting_asc');
          } else {
            attrs.sort = 'asc';
            element.addClass('sorting_desc');
          }
        });
      }
    }
})

.directive('ngOnlyNumbers', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {
        element.keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
               // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
               // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                   // let it happen, don't do anything
                   return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
        });
        //
      }
    };
})

.directive('ngSelect2', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {
        console.log(element);
        element.select2();
      }
    };
})

.directive('ngSelect2Ajax', function() {
    return {
      require: '?ngModel',
      link: function($scope, element, attrs, controller) {

        element.select2({
            placeholder: 'Selecione...',
            //Does the user have to enter any data before sending the ajax request
            minimumInputLength: 3,            
            ajax: {
                //How long the user has to pause their typing before sending the next request
                quietMillis: 150,
                //The url of the json service
                url: '/cliente/cnae/get',
                dataType: 'JSON',
                //Our search term and what page we are on
                data: function (term, page) {
                    return {
                        pageSize: 20,
                        pageNum: page,
                        searchTerm: term,
                        cnae: $scope.cliente.cnae
                    };
                },
                results: function (data, page) {
                    //Used to determine whether or not there are more results available,
                    //and if requests for more data should be sent in the infinite scrolling
                    var more = (page * 20) < data.Total; 
                    return { results: data.Results, more: more };
                }
            },

            formatResult: function (item) { return ('<div>' + item.id + ' - ' + item.text + '</div>'); },
            formatSelection: function (item) { return (item.text); },
            escapeMarkup: function (m) { return m; }
        })

      }
    };
})

;