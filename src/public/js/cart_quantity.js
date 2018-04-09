let plus = document.querySelectorAll('.spinner .btn:first-of-type');
let input = document.querySelectorAll('.spinner input');
let minus = document.querySelectorAll('.spinner .btn:last-of-type');


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

function moreQuantity() {
  let oldValue = parseInt(input[parseInt(this.querySelector('.number').textContent)].value);
    let newVal = oldValue + 1;
    input[parseInt(this.querySelector('.number').textContent)].value = newVal;
  
}

function lessQuantity(i) {
  let oldValue = parseInt(input[parseInt(this.querySelector('.number').textContent)].value);
  if(oldValue > 1) {
    let newVal = oldValue - 1;
    input[parseInt(this.querySelector('.number').textContent)].value = newVal;
  }
}
