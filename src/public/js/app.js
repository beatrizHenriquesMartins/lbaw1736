function addEventListeners() {


  let removeWishlist = document.querySelectorAll('.category-section .category-products .product-wishlist .product-class .cart-btn .btn');
  if(removeWishlist) {
    [].forEach.call(removeWishlist, function(deleter) {
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

  let plus = document.querySelectorAll('.spinner .btn:first-of-type');
  let minus = document.querySelectorAll('.spinner .btn:last-of-type');
  let input = document.querySelectorAll('.spinner input');

  if(plus) {
    let i = 0;
    for(i = 0; i < plus.length; i++) {
      plus[i].addEventListener("click", moreQuantity);
    }
  }

  if(minus) {
    let i = 0;
    for(i = 0; i < minus.length; i++) {
      minus[i].addEventListener("click", lessQuantity);
    }
  }

  if(input) {
    let i = 0;
    for(i = 0; i < input.length; i++) {
      input[i].addEventListener("input", changeQuantity);
    }
  }

  let bans = document.querySelectorAll('#accordion .card .card-body .product .product-class .cart-btn .fa-ban');
  if(bans) {
    let i = 0;
    for(i = 0; i < bans.length; i++) {
      console.log("HERE!!!!");
      bans[i].addEventListener("click", sendBanRequest);
    }
  }

  let unbans = document.querySelectorAll('#accordion .card .card-body .product .product-class .cart-btn .fa-undo');
  if(unbans) {
    let i = 0;
    for(i = 0; i < unbans.length; i++) {
      unbans[i].addEventListener("click", sendUnBanRequest);
    }
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

function sendUnBanRequest() {

  let id = this.closest('div.card').getAttribute('data-id');
  sendAjaxRequest('post', '/api/users/unban', {id: id}, sendUnBanHandlers);

}

function sendUnBanHandlers() {
  if (this.status != 200) window.location = '/';
  let banned = JSON.parse(this.responseText);
  let element = document.querySelector('#accordion .card[data-id="' + banned.id_user + '"]');
  element.remove();

}

function sendBanRequest() {

  let id = this.closest('div.card').getAttribute('data-id');
  sendAjaxRequest('post', '/api/users/ban', {id: id}, sendBanHandlers);

}

function sendBanHandlers() {
  if (this.status != 200) window.location = '/';
  let banned = JSON.parse(this.responseText);
  let element = document.querySelector('#accordion .card[data-id="' + banned.id_user + '"]');
  element.remove();
}

function changeQuantity() {
  let spinner = this.closest('.spinner');

  let input = spinner.querySelector('input');

  let value = parseInt(input.value);

  let id = this.closest('div.product').getAttribute('data-id');

  sendAjaxRequest('post', '/api/cart/' + id + '/quantity/' + value, null, updateCartQuantityHandler);

}

function moreQuantity() {
  let spinner = this.closest('.spinner');
  let input = spinner.querySelector('input');
  let oldValue = parseInt(input.value);
  let newVal = oldValue + 1;

  input.value = newVal;
  let id = this.closest('div.product').getAttribute('data-id');

  sendAjaxRequest('post', '/api/cart/' + id + '/quantity/' + newVal, null, updateCartQuantityHandler);

}

function lessQuantity(i) {
  let spinner = this.closest('.spinner');
  let input = spinner.querySelector('input');
  let oldValue = parseInt(input.value);
  let id = this.closest('div.product').getAttribute('data-id');
  if(oldValue > 1) {
    let newVal = oldValue - 1;

  input.value = newVal;
  sendAjaxRequest('post', '/api/cart/' + id + '/quantity/' + newVal, null, updateCartQuantityHandler);

  }
}

function updateCartQuantityHandler() {
  console.log(this.responseText);
  if (this.status != 200) window.location = '/';

  let newVal = JSON.parse(this.responseText);
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
  updateCartTotal(totalvalue);
  /*if(totalvalue == 0) {
    let final = document.querySelector('.main .final');
    final.remove();
  } else {
    let total = document.querySelector('.main .final .total-order .total');
    let newprice = document.createElement('h3');
    newprice.innerHTML = totalvalue + ' €';
    newprice.setAttribute('class', 'value');
    total.append(newprice);
  }*/
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

function updateCartTotal(newTotal){
  if(newTotal == 0) {
    let final = document.querySelector('.main .final');
    final.remove();
  } else {
    let total = document.querySelector('.main .final .total-order .total');
    let newprice = document.createElement('h3');
    newprice.innerHTML = newTotal + ' €';
    newprice.setAttribute('class', 'value');
    total.append(newprice);
  }
}

addEventListeners();


$(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
        $this.parents('.panel').find('.panel-footer').slideUp();
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.parents('.panel').find('.panel-footer').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
