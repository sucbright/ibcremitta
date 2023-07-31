<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-3">Remita Payments</h2>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Full name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Reference
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Purpose
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        When
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $payment->last_name }} {{ $payment->first_name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $payment->payment_reference }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $payment->amount }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $payment->purpose }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $payment->payment_status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $payment->created_at->timezone(config('timezone.timezone'))
                                            ->isoFormat('ddd, MMM D, YYYY h:mm A') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($payment->payment_status != \App\Enums\PaymentStatus::SUCCESS->value)
                                            <button onclick="verifyPayment(`{{ $payment->transaction_id }}`)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Verify</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    async function verifyPayment(transactionId) {
        try {
            const response = axios.post('{{ route('verify-payment') }}', {
                transactionId: transactionId
            })
            window.location.href = `{{ route('dashboard') }}`

        } catch(error) {
            alert('Error wa oo!')
        }

    }
</script>
