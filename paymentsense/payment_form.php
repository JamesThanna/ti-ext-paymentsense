{{ session()->put('token',$paymentMethod->PrepareCart()['token'])}}
{{ session()->put('paymentId',$paymentMethod->PrepareCart()['orderId'])}}
{{ session()->put('totalAmount',$paymentMethod->GetTotal())}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://web.e.test.connect.paymentsense.cloud/assets/js/client.js"></script>


<style>
#demo-payment iframe { width: 100%; }

#demo-result, #demo-payment, #recurring-demo-payment, #recurring-payment { padding: 5px; }

#errors li { color: #B00; }

iframe.threeDs {
    width: 370px;
    height: 366px;
    margin: 100px 0 0 -175px;
    position: fixed;
    top: 0;
    left: 50%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.6);
}
  .checkout-btn{
    display:none;
  }
  
  .form-control{
   font-weight:900; 
    color:dark-grey;
    font-size:14px;
  }
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  display:none;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
  
</style>

<div id="paymentForm">
  


<div class="loader"></div>

<div id="demo-payment">
  
<input type="hidden" name="pToken" required value="{{ session()->get('token') }}">
  <input type="hidden" name="paymentId" required value="{{ session()->get('paymentId') }}">
</div>
<div id="Address">
  

<div class="form-group">
  
  <h6>
    Billing Address: 
  </h6>
  <input type="text" id="address1"  required class="form-control" placeholder="Address 1">
  </div>
<div class="form-group">
  <input type="text" id="address2" required class="form-control" placeholder="Address 2">
</div>
<div class="form-group">
  <input type="text" id="address3"  class="form-control" placeholder="Address 3">
</div>
<div class="form-group">
  <input type="text" id="county" required class="form-control" placeholder="County">
</div>
<div class="form-group">
  <input type="text" id="city" required  class="form-control" placeholder="City">
</div>
<div class="form-group">
  <input type="text" id="postcode"  required  class="form-control" placeholder="Post Code">
</div>
</div>
<a  id="testPay"  style="color:white"  class="btn btn-primary btn-lg"  >Make Payment</a>
<script>

  
  var additionalInfo =  {
        billingAddress: {
          address1: address1,
          address2: address2,
          address3: address3,
          county: county,
          city: city,
          postcode: postcode,
          countryCode:"826",
        }
          } 
    
  $("#testPay").on("click", function() {

     var address1 = $("#address1").val();
   additionalInfo.billingAddress.address1 = address1; 
}); 
  $("#testPay").on("click", function() {

     var address2 = $("#address2").val();
   additionalInfo.billingAddress.address2 = address2; 
});       
  $("#testPay").on("click", function() {

     var address3 = $("#address3").val();
   additionalInfo.billingAddress.address3 = address3; 
});
  $("#testPay").on("click", function() {

     var county = $("#county").val();
   additionalInfo.billingAddress.county = county; 
});
  $("#testPay").on("click", function() {

  var city = $("#city").val();
   additionalInfo.billingAddress.city = city; 
});
  $("#testPay").on("click", function() {
  var postcode = $("#postcode").val();
   additionalInfo.billingAddress.postcode = postcode; 
  });  
  
var config = {
    paymentDetails: {
        amount: "{{ session()->get('totalAmount') }}",
        currencyCode: "826",
        paymentToken: "{{ session()->get('token') }}"
    },
    containerId: "demo-payment",
    fontCss: ['https://fonts.googleapis.com/css?family=Do+Hyeon'],
    styles: {
        base: {
            default: {
                color: "black",
                textDecoration: "none",
                fontFamily: "'Do Hyeon', sans-serif",
                boxSizing: "border-box",
                padding: ".375rem .75rem",
                boxShadow: 'none',
                fontSize: '1rem',
                borderRadius: '.25rem',
                lineHeight: '1.5',
                backgroundColor: '#fff',

            },
            focus: {
                color: '#495057',
                borderColor: '#80bdff',
            },
            error: {
                color: "#B00",
                borderColor: "#B00"
            },
            valid: {
                color: "green",
                borderColor: 'green'
            },
            label: {
                display: 'none'
            }
        },
        cv2: {
            container: {
                width: "25%",
                float: "left",
                boxSizing: "border-box"
            },
            default: {
                borderRadius: "0 .25rem .25rem 0"
            }
        },
        expiryDate: {
            container: {
                width: "25%",
                float: "left",
                borderRadius: '0rem',
            },
            default: {
                borderRadius: "0",
                borderRight: "none"
            },
        },

        cardNumber: {
            container: {
                width: "50%",
                float: "left",
            },
            default: {
                borderRadius: ".25rem 0 0 .25rem",
                borderRight: "none"
            },
        }
    }
}

var connectE = new Connect.ConnectE(config, displayErrors);
var btn = document.getElementById("testPay");

$('#testPay').on('click',
    function() {
        var btn = $(this);
        btn.button('loading');
        connectE.executePayment(additionalInfo)
            .then(function(data) {
          
                $("#demo-payment").hide();
                $("#testPay").hide();
                $("#demo-result").show();
                $("#status-code").text(data.statusCode);
                $("#auth-code").text(data.authCode);
         $('.checkout-btn').click();
          $('.loader').css('display','block'); 
          
            }).catch(function(data) {
                    console.log('Payment Request failed: ' + data);
                    $("#errors").text(data);
                }
            ).finally(function() {
                btn.button('reset');
              
       
           $('#Address').hide();

     
            });
    });

function displayErrors(errors) {
    var errorsDiv = document.getElementById('errors');
    errorsDiv.innerHTML = '';
    if (errors && errors.length) {
        var list = document.createElement("ul");
        errors.forEach(function(error) {
            var item = document.createElement("li");
            item.innerText = error.message;
            list.appendChild(item);
        });
        errorsDiv.appendChild(list);
    }


}
  

  var connectE = new Connect.ConnectE(config, displayErrorsCallback, onSubmitTriggered);


    
</script>
  
  </div>

