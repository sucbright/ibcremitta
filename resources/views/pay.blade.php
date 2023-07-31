<!DOCTYPE html>
  <html lang="en">
     <head>
        <title>Remita Checkout Sample</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
     </head>
     <body>
        <div class="border-2 grid grid-cols-1 min-h-screen">
          <div class="max-w-5xl w-1/3 mx-auto p-8">
            <form id="payment-form">
              <div class="grid grid-cols-1 space-y-5">
                <div>
                  <input type="text" class="w-full py-3 rounded border border-gray-300 outline-none ring ring-blue-100 focus:border focus:ring-blue-400" placeholder="First Name" name="firstName">
                </div>
                <div>
                  <input type="text" class="w-full py-3 rounded border border-gray-300 outline-none ring ring-blue-100 focus:border focus:ring-blue-400" placeholder="Last Name" name="lastName">
                </div>
                <div>
                  <input type="text" class="w-full py-3 rounded border border-gray-300 outline-none ring ring-blue-100 focus:border focus:ring-blue-400" placeholder="Email" name="email">
                </div>
                <div>
                  <input type="text" class="w-full py-3 rounded border border-gray-300 outline-none ring ring-blue-100 focus:border focus:ring-blue-400" placeholder="Narration" name="narration">
                </div>
                <div>
                  <input type="text" class="w-full py-3 rounded border border-gray-300 outline-none ring ring-blue-100 focus:border focus:ring-blue-400" placeholder="Amount" name="amount">
                </div>
                <button type="button" onclick="makePayment()" class="bg-teal-500 text-white py-4 rounded">Pay</button>


              </div>
            </form>
          </div>
        </div>
      <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
      <script>
      async function makePayment() {
          const response = await axios.post('{{ route('create-transaction') }}', {})
          const transactionId = response.data.transactionId
          const form = document.querySelector("#payment-form");
          const paymentEngine = RmPaymentEngine.init({
              key: 'QzAwMDAyNzEyNTl8MTEwNjE4NjF8OWZjOWYwNmMyZDk3MDRhYWM3YThiOThlNTNjZTE3ZjYxOTY5NDdmZWE1YzU3NDc0ZjE2ZDZjNTg1YWYxNWY3NWM4ZjMzNzZhNjNhZWZlOWQwNmJhNTFkMjIxYTRiMjYzZDkzNGQ3NTUxNDIxYWNlOGY4ZWEyODY3ZjlhNGUwYTY=',
              transactionId: transactionId,
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
