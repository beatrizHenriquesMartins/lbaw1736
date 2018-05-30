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

  let addMessageSupport = document.querySelector("#buttonSend_writeMessage");
  if(addMessageSupport) {
    addMessageSupport.addEventListener("click", sendMessageSupportRequest);
  }


  let orderPayment = document.querySelector('.order-section .order-information .btns .btn-success');
  if(orderPayment){
    orderPayment.addEventListener("click", processOrder);
  }

  let paymentButtons = document.querySelectorAll('.payment>div>button.btn-success');
  if(paymentButtons){
    let i = 0;
    for(i=0; i < paymentButtons.length; i++){
      paymentButtons[i].addEventListener("click", cartPayment);
    }
  }

  let confirmPaymentButtons = document.querySelectorAll('#button-confirmpayment');
  if(confirmPaymentButtons){
    let i = 0;
    for(i=0; i < confirmPaymentButtons.length; i++){
      confirmPaymentButtons[i].addEventListener("click", confirmPayment);
    }
  }

  let cancelPaymentButtons = document.querySelectorAll('#button-cancelpayment');
  if(cancelPaymentButtons){
    let i = 0;
    for(i=0; i < cancelPaymentButtons.length; i++){
      cancelPaymentButtons[i].addEventListener("click", cancelPayment);
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

function sendRemoveCommentRequest() {
  let parent = this.closest("#content");
  let id_product = parent.querySelector(".product-section").getAttribute("data-id");
  let id_purchase = this.closest(".review").getAttribute("data-id");
  sendAjaxRequest('delete', '/api/remove/comment', {id_product:id_product, id_purchase:id_purchase}, sendRemoveCommentHandler);

}

function sendRemoveCommentHandler() {
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

  sendAjaxRequest('put', '/api/add/address', {address:address,zipcode:zipcode,country:country,city:city}, sendAddAddressHandler);

}

function sendAddAddressHandler() {
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
        <button class="btn btn-default btn-sm">
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

function sendMessageSupportRequest() {
  let parent = this.closest('#formGroup_writeMessage');
  let message = parent.querySelector('#message-text').value;
  let id_client = parent.getAttribute('data-id');
  if(message != "")
    sendAjaxRequest('post', '/api/messagesupport', {message:message, id_client:id_client}, sendMessageSupportHandler);

}

function sendMessageSupportHandler() {

  if (this.status != 200) window.location = '/';
  let message = JSON.parse(this.responseText);

  let body = document.querySelector('#exchangeMessages');
  let date = new Date(message.datesent);
  let element = document.createElement('div');
  dateString = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
  element.setAttribute('class', 'row');
  element.setAttribute('class', 'msg_container');
  element.setAttribute('class', 'base_sent');
  element.innerHTML = '<div class="col-xs-10 col-md-10"><div class="messages msg_sent"><p>'
                      + message.message + '</p><time datetime="2009-11-13">' + message.chatsupport.username +
                      ' • ' + dateString +
                      '</time></div></div><div id="div_chatSupportPhoto" class="col-md-2 col-xs-2 avatar"><img id="chatSupportPhoto" src="' +
                      message.chatsupport.imageurl + '" class=" img-responsive "></div>';
  body.append(element);

  document.querySelector('#formGroup_writeMessage #message-text').value = "";

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
//  if (this.status != 200) window.location = '/';
  let cart = JSON.parse(this.responseText);
  let element = document.createElement("div");

  if(cart.message == "Not Authorized to add to wishlist") {
    element.setAttribute("class", "alert alert-danger");
    element.innerHTML = ` <strong>Error!</strong> Couldn't add to Wishlist.`;
  }
  else {
    element.setAttribute("class", "alert alert-success");
    element.innerHTML = ` <strong>Success!</strong> ` + cart.name +` added to Wishlist.`;
  }
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

  if(cart.message == "Not Authorized to add to cart") {
    element.setAttribute("class", "alert alert-danger");
    element.innerHTML = ` <strong>Error!</strong> Couldn't add to Cart.`;
  }
  else {
    element.setAttribute("class", "alert alert-success");
    element.innerHTML = ` <strong>Success!</strong> ` + cart.name +` added to Cart.`;
  }
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
  let nifInput = document.querySelector('.nif input');
  let nifValue = nifInput.value;


  let selectAddressOrder = document.querySelectorAll('.addresses .form-check input');
  var countSelectedAddr = 0;
  var selAddr = -1;

  for(var i =0; i < selectAddressOrder.length; i++){
    if(selectAddressOrder[i].checked == true){
      selAddr = i;
      countSelectedAddr ++;
    }
  }
  if(selAddr > -1 && countSelectedAddr == 1){
    $("#selectedAddr").val(selAddr);
    $('#nifForm').val(nifValue);
    $("#form").submit();
  }

  else{
    alert("You must select one and only one address");
  }
}

function cartPayment(){
  let addressId = document.querySelector('.address-cartpayment').getAttribute('id_address');
  let nif = document.querySelector('.nif').innerHTML;
  nif = (nif.trim) ? nif.trim() : nif.replace(/^\s+/,'');
  if(!nif || nif == null || nif == "")
    nif = "Undefined";
  sendAjaxRequest('post', 'api/payment/'+addressId+'/nif/'+nif, null, cartPaymentResponse);
}

function cartPaymentResponse(){
  if (this.status != 200) window.location = '/';

  let response = JSON.parse(this.responseText);

  let element = document.createElement("div");

  if(response != 0) {
    element.setAttribute("class", "alert alert-danger");
    element.innerHTML = ` <strong>Error!</strong> There is not enough quantity In Stock for you to make your purchase. You should try later this week`;
  }
  else {
    element.setAttribute("class", "alert alert-success");
    element.innerHTML = ` <strong>Success!</strong> Ỳour payment has been made with success. Now an admin must confirm it, so it can be sent to your address`;
  }
  let section = document.querySelector("#content");

  let breadcrumbs = section.querySelector("#breadcrumbs");

  section.insertBefore(element, breadcrumbs.nextSibling);

  setTimeout(function(){ element.remove(); }, 2000);


}

function confirmPayment(){
  let id = this.closest('.user-payment').getAttribute('id_purchase');
  this.closest('.user-payment').remove();
  id = parseInt(id);
  sendAjaxRequest('post', 'api/confirm_payment/'+id, null, confirmPaymentResponse);
}

function confirmPaymentResponse(){
  //if (this.status != 200) window.location = '/';
  let response = JSON.parse(this.responseText);



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
    msg_body.append(new_msg);
  }
}

function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();

  var id_token = googleUser.getAuthResponse().id_token;
  sendAjaxRequest('post', 'googleauth/', {id:id_token, name:profile.getName(), email:profile.getEmail(), photo:profile.getImageUrl()}, googleRegisterHandler);
}

function googleRegisterHandler() {
  if(this.status != 200) window.location='/';

  gapi.load('auth2',function(){
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function(){
            document.getElementById("logo").click();
        });
      });
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    });
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
