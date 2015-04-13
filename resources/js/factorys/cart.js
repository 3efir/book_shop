App.factory('cartFactory',  function($http) {
	this.cart = {
		products: {}
	};
	this.cart.count = function() {
		if(this.products) {
			var count = Object.keys(this.products).length;
		}
		else {
			var count = 0;
		}
		return count;
	},
	this.cart.load = function () {
		if(localStorage.cart) {
			this.products = $http.get('/book_shop/cart/getCount');
		}
		else {
			this.products = {};
		}
	}
	return this.cart;
});