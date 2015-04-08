var App = angular.module('main', []);
App.controller('loginController', function(){
	this.href = "/book_shop/login";
	this.name = "Вход";
/*     jsonService.getJson(function(results) {
        $scope.json = results;
    }); */
	//console.log(document.cookie);
});
/* App.service('jsonService', function($http) {
	return {
		getJson: function(callback) {
			$http.get('/book_shop/login/getLogin').success(callback);
		}
	};
}); */