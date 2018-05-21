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

  let send = document.querySelector('.chat-window .panel .panel-footer .input-group .btn');
  if(send) {
    send.addEventListener("click", sendMessageRequest);
  }

  let removeAddresses = document.querySelectorAll('.addresses .address .col-xs-3 .btn');
  if(removeAddresses) {
    let i = 0;
    for(i = 0; i < removeAddresses.length; i++) {
      removeAddresses[i].addEventListener("click", sendRemoveAddressRequest);
    }
  }

  let addAddress = document.querySelector('.addresses .addAddress .btn');
  if(addAddress) {
    addAddress.addEventListener("click", sendAddAddressRequest);
  }

  let removeComments = document.querySelectorAll('.review .removeComment #removeComment');
  if(removeComments) {
    let i = 0;
    for(i = 0; i < removeComments.length; i++) {
      removeComments[i].addEventListener("click", sendRemoveCommentRequest);
    }
  }

}


let orderPayment = document.querySelector('.order-section .order-information .btns .btn-success');
if(orderPayment){
  orderPayment.addEventListener("click", processOrder);
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

function sendRemoveCommentRequest() {
  let parent = this.closest("#content");
  let id_product = parent.querySelector(".product-section").getAttribute("data-id");
  let id_purchase = this.closest(".review").getAttribute("data-id");
  sendAjaxRequest('delete', '/api/remove/comment', {id_product:id_product, id_purchase:id_purchase}, sendRemoveCommentHandler);

}

function sendRemoveCommentHandler() {
  console.log(this.responseText);
  if (this.status != 200) window.location = '/';
  let comment = JSON.parse(this.responseText);

  let element = document.querySelector('.review[data-id="'+ comment.id_purchase +'"]');

  element.remove();

  let msg = document.createElement("div");
  msg.setAttribute("class", "alert alert-success");
  msg.innerHTML = ` <strong>Success!</strong> comment Deleted.`;
  let section = document.querySelector("#content");

  let breadcrumbs = section.querySelector("#breadcrumbs");

  section.insertBefore(msg, breadcrumbs.nextSibling);

  setTimeout(function(){ msg.remove(); }, 2000);

}

function sendAddAddressRequest() {
  let addAddress = this.closest(".addAddress");
  let address = addAddress.querySelector(".street").value;
  let zipcode = addAddress.querySelector(".zipcode").value;
  let country = addAddress.querySelector(".country").value;
  let city = addAddress.querySelector(".city").value;
  console.log(address);
  console.log(zipcode);
  console.log(country);
  console.log(city);
  sendAjaxRequest('put', '/api/add/address', {address:address,zipcode:zipcode,country:country,city:city}, sendAddAddressHandler);

}

function sendAddAddressHandler() {
  console.log(this.responseText);
  if (this.status != 200) window.location = '/';
  let address = JSON.parse(this.responseText);

  if(address != "Already Exists") {

    let element = document.createElement("li");
    element.setAttribute('class', 'row address');
    element.setAttribute('data-id', address.id_address);

    element.innerHTML = `<div class="col-xs-9">
        `+ address.address +` `+ address.city +` `+ address.country +`
    </div>

    <div class="col-xs-3">
        <button type="button" class="btn btn-default btn-sm">
            <span class="fa fa-remove">
            </span>
        </button>
    </div>`;

    let ul =document.querySelector('.addresses ul');

    let li =document.querySelector('.addresses ul li.addAddress');

    ul.insertBefore(element, li);

    let button = element.querySelector(".col-xs-3 .btn");
    button.addEventListener("click", sendRemoveAddressRequest);

    let msg = document.createElement("div");
    msg.setAttribute("class", "alert alert-success");
    msg.innerHTML = ` <strong>Success!</strong> ` + address.address + ` ` + address.city + ` ` + address.country +` added to Addresses .`;
    let section = document.querySelector("#content");

    let breadcrumbs = section.querySelector("#breadcrumbs");

    section.insertBefore(msg, breadcrumbs.nextSibling);

    setTimeout(function(){ msg.remove(); }, 2000);  }
}


function sendRemoveAddressRequest() {
  let addressId = this.closest(".address").getAttribute("data-id");
  sendAjaxRequest('delete', '/api/remove/address', {addressId:addressId}, sendRemoveAddressHandler);

}

function sendRemoveAddressHandler() {
  console.log(this.responseText);
  if (this.status != 200) window.location = '/';
  let address = JSON.parse(this.responseText);

  let element = document.querySelector('.addresses .address[data-id="'+ address.id_address +'"]');

  element.remove();

  let msg = document.createElement("div");
  msg.setAttribute("class", "alert alert-success");
  msg.innerHTML = ` <strong>Success!</strong> ` + address.address + ` ` + address.city + ` ` + address.country +` removed from Addresses .`;
  let section = document.querySelector("#content");

  let breadcrumbs = section.querySelector("#breadcrumbs");

  section.insertBefore(msg, breadcrumbs.nextSibling);

  setTimeout(function(){ msg.remove(); }, 2000);

}


function sendMessageRequest() {
  let parent = this.closest('.input-group');
  let message = parent.querySelector('.chat_input').value;
  if(message != "")
    sendAjaxRequest('post', '/api/message', {message:message}, sendMessageHandler);

}

function sendMessageHandler() {
  if (this.status != 200) window.location = '/';
  let message = JSON.parse(this.responseText);
  let body = document.querySelector('.chat-window .panel .panel-body');
  let date = new Date(message.datesent);
  let element = document.createElement('div');
  dateString = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
  element.setAttribute('class', 'row');
  element.setAttribute('class', 'msg_container');
  element.setAttribute('class', 'base_sent');
  element.innerHTML = '<div class="col-xs-10 col-md-10"><div class="messages msg_sent"><p>'
                      + message.message + '</p><time datetime="2009-11-13">' + message.client.username +
                      ' • ' + dateString +
                      '</time></div></div><div class="col-md-2 col-xs-2 avatar"><img src="' +
                      message.client.imageurl + '" class=" img-responsive "></div>';
  body.append(element);
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
  if (this.status != 200) window.location = '/';

  let productChanged = JSON.parse(this.responseText);
  let input = document.querySelector('div.product.product-cart[data-id="' + productChanged.id_product + '"] .quantity input');

  let quantity = parseInt(input.value);

  if(quantity != 0)
    updateCartTotal(this.responseText, input.value);
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

function removeCartHandler(){
  if (this.status != 200) window.location = '/';

  updateCartTotal(this.responseText, 0);
}

function updateCartTotal(responseText, newQuantity) {
  let productChanged = JSON.parse(responseText);
  let element = document.querySelector('div.product.product-cart[data-id="' + productChanged.id_product + '"]');
  let productprice = element.querySelector('.product-name .price');
  let productvalue = productprice.innerHTML;
  productvalue = productvalue.match(/\S+/g) || [];
  productvalue = productvalue[0];
  if(newQuantity == 0)
    element.remove();


  let totalprice = document.querySelector('.main .final .total-order .total .value');
  let totalvalue = totalprice.innerHTML;
  totalvalue = totalvalue.match(/\S+/g) || [];
  totalvalue = totalvalue[0];
  totalprice.remove();
  totalvalue = parseInt(totalvalue) + parseInt(productvalue) * ( parseInt(newQuantity) - parseInt(productChanged.quantity) );
  changeCartTotal(totalvalue);

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

  let element = document.createElement("div");
  element.setAttribute("class", "alert alert-success");
  element.innerHTML = ` <strong>Success!</strong> ` + cart.name +` added to Wishlist.`;
  let section = document.querySelector("#content");

  let breadcrumbs = section.querySelector("#breadcrumbs");

  section.insertBefore(element, breadcrumbs.nextSibling);

  setTimeout(function(){ element.remove(); }, 2000);}

function sendAddCartRequest() {
  let id = this.closest('div.product-section').getAttribute('data-id');
  sendAjaxRequest('put', '/api/cart/' + id, null, AddCartHandler);
}

function AddCartHandler() {

  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);


  let element = document.createElement("div");
  element.setAttribute("class", "alert alert-success");
  element.innerHTML = ` <strong>Success!</strong> ` + cart.name +` added to Cart.`;
  let section = document.querySelector("#content");

  let breadcrumbs = section.querySelector("#breadcrumbs");

  section.insertBefore(element, breadcrumbs.nextSibling);

  setTimeout(function(){ element.remove(); }, 2000);
}

function changeCartTotal(newTotal){
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


function processOrder(){
  let selectAddressOrder = document.querySelectorAll('.addresses .form-check input');
  var countSelectedAddr = 0;
  var selAddr = -1;

  for(var i =0; i < selectAddressOrder.length; i++){
    if(selectAddressOrder[i].checked == true){
      selAddr = i;
      countSelectedAddr ++;
    }
  }
  console.log(selAddr);
  if(selAddr > -1 && countSelectedAddr == 1){
    console.log("Hi everybody");
    sendAjaxRequest('post', 'api/cart_payment/'+i, null, processOrderHandler);
  }

}

function processOrderHandler(){

}

addEventListeners();

setInterval(refreshChat, 10 * 1000);

function refreshChat() {
  let msg_body = document.querySelector("#container-chat #chat_window_1 .panel .panel-body");
  if(msg_body)
    getChatMsgRequest();
}

function getChatMsgRequest() {
  sendAjaxRequest('get', '/api/getmessages', null, getChatMsgHandler);
}

function pad2(number) {

     return (number < 10 ? '0' : '') + number

}

function getChatMsgHandler() {
  if (this.status != 200) window.location = '/';
  let chat_msgs = JSON.parse(this.responseText);

  let msg_body = document.querySelector("#container-chat #chat_window_1 .panel .panel-body");
  msg_body.innerHTML = '';

  let i = 0;
  for(i = 0; i < chat_msgs.length; i++) {
    let new_msg = document.createElement("div");
    let date = new Date(chat_msgs[i].datesent);
    if(chat_msgs[i].sender == "chatSupport") {
      new_msg.setAttribute("class", "row msg_container base_receive");
      new_msg.innerHTML =  '<div class="col-md-2 col-xs-2 avatar"><img src="'
                          + chat_msgs[i].chatsupport.imageurl
                          + '" class=" img-responsive "></div><div class="col-xs-10 col-md-10"><div class="messages msg_receive"><p>'
                          + chat_msgs[i].message +
                          '</p><time datetime="2009-11-13">'
                          + chat_msgs[i].chatsupport.username +
                          ' • '
                          + date
                          '</time></div></div>';
    }
    if(chat_msgs[i].sender == "Client") {
      new_msg.setAttribute("class", "row msg_container base_sent");
      new_msg.innerHTML =  '<div class="col-xs-10 col-md-10"><div class="messages msg_sent"><p>'
                           + chat_msgs[i].message
                           + '</p><time datetime="2009-11-13">'
                           + chat_msgs[i].client.username
                           + '  • '
                           + date.getFullYear() + '-' + pad2((date.getMonth() + 1)) + '-' + pad2(date.getDate())
                           + '</time></div></div><div class="col-md-2 col-xs-2 avatar"><img src="'
                           + chat_msgs[i].client.imageurl
                           + '" class=" img-responsive "></div>';
    }
    console.log(new_msg);
    msg_body.append(new_msg);
  }
}


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
