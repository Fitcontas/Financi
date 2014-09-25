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
        element.select2();
      }
    };
})

;