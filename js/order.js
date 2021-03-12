var total = 0;
var output = document.getElementById("order-total");
var quantity = document.getElementsByClassName('quantity');
var prices = document.getElementsByClassName('price');

for(var i = 0; i < quantity.length; i++) {

    quantity[i].addEventListener('change', function(){
          for(var j = 0; j < prices.length; j++)
          {
          	total += Number(prices[j].innerHTML) * Number(quantity[j].value);
              
          }
          output.innerHTML = "Order Total: <span class='total'>£" + total + "<input type='hidden' value="+ total +" name='total'/>";
          total = 0;
    }, false);
}