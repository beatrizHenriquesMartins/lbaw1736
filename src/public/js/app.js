function addEventListeners() {


  let removeWishlist = document.querySelectorAll('.category-section .category-products .product-wishlist .product-class .cart-btn .btn');
  if(removeWishlist) {
    [].forEach.call(removeWishlist, function(deleter) {
      console.log("HERE");
      deleter.addEventListener('click', sendRemoveWishlistRequest);
    });
  }

  let removeCart = document.querySelectorAll('.category-section .category-products .product-cart .product-class .cart-btn .btn');
  if(removeCart) {
    [].forEach.call(removeCart, function(deleter) {
      deleter.addEventListener('click', sendRemoveCartRequest);
    });
  }

  let addWishlist = document.querySelectorAll('.product-section .btns .fav-btn .btn');
  if(addWishlist) {
    [].forEach.call(addWishlist, function(deleter) {
      deleter.addEventListener('click', sendAddWishlistRequest);
    });
  }

  let addCart = document.querySelectorAll('.product-section .btns .cart-btn .btn');
  if(addCart) {
    [].forEach.call(addCart, function(deleter) {
      deleter.addEventListener('click', sendAddCartRequest);
    });
  }

  let removeAllCart = document.querySelectorAll('.main .final .delete-cart .delete-cart-btn .btn');
  if(removeAllCart) {
    [].forEach.call(removeAllCart, function(deleter) {
      deleter.addEventListener('click', sendRemoveAllCartRequest);
    });
  }
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function sendRemoveWishlistRequest() {
  let id = this.closest('div.product').getAttribute('data-id');
  sendAjaxRequest('delete', '/api/wishlist/' + id, null, removeWishlistHandler);
}

function removeWishlistHandler() {
  if (this.status != 200) window.location = '/';
  let wishlist = JSON.parse(this.responseText);
  let element = document.querySelector('div.product.product-wishlist[data-id="' + wishlist.id_product + '"]');
  element.remove();
}

function sendRemoveCartRequest() {
  let id = this.closest('div.product').getAttribute('data-id');
  sendAjaxRequest('delete', '/api/cart/' + id, null, removeCartHandler);
}

function removeCartHandler() {
  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);
  let element = document.querySelector('div.product.product-cart[data-id="' + cart.id_product + '"]');
  let productprice = element.querySelector('.product-name .price');
  let productvalue = productprice.innerHTML;
  productvalue = productvalue.match(/\S+/g) || [];
  productvalue = productvalue[0];
  element.remove();


  let totalprice = document.querySelector('.main .final .total-order .total .value');
  let totalvalue = totalprice.innerHTML;
  totalvalue = totalvalue.match(/\S+/g) || [];
  totalvalue = totalvalue[0];
  totalprice.remove();

  totalvalue -= productvalue;
  if(totalvalue == 0) {
    let final = document.querySelector('.main .final');
    final.remove();
  } else {
    let total = document.querySelector('.main .final .total-order .total');
    let newprice = document.createElement('h3');
    newprice.innerHTML = totalvalue + ' €';
    newprice.setAttribute('class', 'value');
    total.append(newprice);
  }
}

function sendRemoveAllCartRequest() {
  sendAjaxRequest('delete', '/api/cart/', null, removeAllCartHandler);
}

function removeAllCartHandler() {
  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);
  let elements = document.querySelectorAll('div.product-cart');
  elements.forEach(function(element) {
    element.remove();
  });
  let final = document.querySelector('.main .final');
  final.remove();

}

function sendAddWishlistRequest() {
  let id = this.closest('div.product-section').getAttribute('data-id');
  sendAjaxRequest('put', '/api/wishlist/' + id, null, AddWishlistHandler);
}

function AddWishlistHandler() {
  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);

}

function sendAddCartRequest() {
  let id = this.closest('div.product-section').getAttribute('data-id');
  sendAjaxRequest('put', '/api/cart/' + id, null, AddCartHandler);
}

function AddCartHandler() {

  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);

}

addEventListeners();
