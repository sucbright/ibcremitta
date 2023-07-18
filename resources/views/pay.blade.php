<!DOCTYPE html>
  <html lang="en">
     <head>
        <title>Remita Checkout Sample</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
        <style type="text/css">
           .button {background-color: #1CA78B;  border: none;  color: white;  padding: 15px 32px;  text-align: center;  text-decoration: none;  display: inline-block;  font-size: 16px;  margin: 4px 2px;  cursor: pointer;  border-radius: 4px;}
           input {  max-width: 30%;}
        </style>
     </head>
     <body>
        <div class="container mt-3">
           <h2>Remita Checkout Demo</h2>
           <p>Try out our Payment Gateway</p>
           <form onsubmit="makePayment()" id="payment-form">
              <div class="form-floating mb-3 mt-3">
                 <input type="text" class="form-control" id="js-firstName" placeholder="Enter First Name" name="firstName">
                 <label for="email">First Name</label>
              </div>
              <div class="form-floating mb-3 mt-3">
                 <input type="text" class="form-control" id="js-lastName" placeholder="Enter Last Name" name="lastName">
                 <label for="email">Last Name</label>
              </div>
              <div class="form-floating mb-3 mt-3">
                 <input type="text" class="form-control" id="js-email" placeholder="Enter Email" name="email">
                 <label for="email">Email</label>
              </div>
              <div class="form-floating mt-3 mb-3">
                 <input type="text" class="form-control" id="js-narration" placeholder="Enter Narration" name="narration">
                 <label for="pwd">Narration</label>
              </div>
              <div class="form-floating mt-3 mb-3">
                 <input type="text" class="form-control" id="js-amount" placeholder="Enter Amount" name="amount">
                 <label for="pwd">Amount</label>
              </div>
              <input type="button" onclick="makePayment()" value="Submit" button class="button"/>
           </form>
        </div>
        <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
         <script>
      function makePayment() {
          const form = document.querySelector("#payment-form");
          const paymentEngine = RmPaymentEngine.init({
              key: 'QzAwMDAyNzEyNTl8MTEwNjE4NjF8OWZjOWYwNmMyZDk3MDRhYWM3YThiOThlNTNjZTE3ZjYxOTY5NDdmZWE1YzU3NDc0ZjE2ZDZjNTg1YWYxNWY3NWM4ZjMzNzZhNjNhZWZlOWQwNmJhNTFkMjIxYTRiMjYzZDkzNGQ3NTUxNDIxYWNlOGY4ZWEyODY3ZjlhNGUwYTY=',
              transactionId: '{{ $transactionId }}',
              customerId: form.querySelector('input[name="email"]').value,
              firstName: form.querySelector('input[name="firstName"]').value,
              lastName: form.querySelector('input[name="lastName"]').value,
              email: form.querySelector('input[name="email"]').value,
              amount: form.querySelector('input[name="amount"]').value,
              narration: 'Giving via Remita',
              onSuccess: function (response) {
                const payload = JSON.stringify(response)
                const result = JSON.parse(payload)
                console.log(result.transactionId)
                axios.post('{{ route('verify-payment') }}', {
                    transactionId: result.transactionId
                })
                  // axios.post('{{ route('verify-payment') }}', {response.transactionId})
                  // console.log('callback Successful Response', response);
                  // console.log(JSON.stringify(response));
              },
              onError: function (response) {
                  console.log('callback Error Response', response);

              },
              onClose: function () {
                  console.log("closed");
              }
          });
          paymentEngine.showPaymentWidget();
      }

      // window.onload = function () {
      //     setDemoData();
      // };
  </script>
     </body>
  </html>
