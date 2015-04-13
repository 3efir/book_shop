App.directive('header', function() {
  return {
    restrict: 'AE',
    replace: false,
    templateUrl: '/~user8/book_shop/index/header/',
	async: true
  };
});
App.directive('menu', function() {
  return {
    restrict: 'AE',
    replace: false,
    templateUrl: '/~user8/book_shop/index/menu/',
	async: true
  };
});