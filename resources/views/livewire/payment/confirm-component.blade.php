<div>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 mb-4 sm:mx-2">
            @include('livewire.payment.steps.steps-bars-payment')
        </div>
        <form id="formData" method="post">
            @csrf
            @method('POST')
            <div class="sm:flex">
                <div class="mx-4 sm:mx-2 sm:w-9/12">
                    <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                        <x-card-header>
                            <span class="font-bold text-gray-600">{{ __('Card Information') }}</span>
                        </x-card-header>
                        <x-card-body>
                            @error('payment')
                                <div class="p-3 mb-4 text-sm text-red-700 border border-red-200 rounded bg-red-50">{{ $message }}</div>
                            @enderror

                            <div id="payment-element"></div>
                            <div id="error_payment" class="mt-2 text-sm text-red-600"></div>

                            <div class="sm:flex">
                                <x-input type="hidden" id="transportation" wire:model.lazy="transportation" class="sm:mr-2" />
                                <x-input type="hidden" id="amount" wire:model.lazy="amount" class="sm:mr-2" />
                                <x-input type="hidden" id="order_number" wire:model.lazy="order_number"
                                    class="sm:ml-2" />
                            </div>
                        </x-card-body>
                    </div>

                    <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                        <div class="items-center pt-1 pb-3 border-b">
                            <span class="font-semibold text-gray-600 text-md ">{{ __('Receiver information') }}</span>
                        </div>

                        <div class="mt-2">
                            @include('livewire.payment.component.contact')
                        </div>
                    </div>
                </div>

                <div class="sm:mx-2 sm:w-3/12">
                    <x-button id="paymentConfirm" @click="open = false" type="submit"
                        class="w-full mb-4 rounded-none disabled:opacity-60 sm:rounded">
                        <svg fill="currentColor" class="h-5 mr-2 bi bi-credit-card-2-back-fill" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5H0V4zm11.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zM0 11v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1H0z" />
                        </svg>
                        {{ __('Confirmed') }}
                        <div class="flex justify-end w-full">
                            <x-icon-spin id="spinPayment" class="hidden ml-1" />
                        </div>
                    </x-button>

                    <div class="px-4 py-4 mb-4 shadow sm:rounded-lg sm:px-6">
                        <x-card-header class="font-bold">{{ __('Purshase Details') }}</x-card-header>

                        <x-card-body>
                            <div class="mb-2 text-gray-700 border-b">
                                <span>{{ __('Number of order') }}:</span>
                                <div id="order_number" class="float-right font-semibold">{{ $order_number }}</div>
                            </div>
                            <div class="text-gray-700">
                                <div class="font-semibold">{{ __($delivery_method->name) }}</div>
                            </div>
                        </x-card-body>
                    </div>

                    <div class="px-4 py-4 mb-4 shadow sm:rounded-lg sm:px-6">
                        @include('livewire.payment.component.products')
                    </div>

                    <div class="px-4 py-4 mb-4 shadow sm:px-6 sm:rounded-lg">
                        @if($method == 2)
                            <div class="mb-2 border-b">
                                <span class="mr-4 text-gray-800 text-md">{{__('Transportation')}}</span>
                                <span class="float-right font-bold text-gray-700 text-md">${{ number_format($transportation, 2) }}</span>
                            </div>
                            <div class="mb-2 border-b">
                                <span class="mr-4 text-gray-800 text-md">{{__('Purchase value')}}</span>
                                <span class="float-right font-bold text-gray-700 text-md">${{ number_format($amount, 2) }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="mr-4 font-bold text-gray-800 uppercase text-md">{{__('Total Cost')}}</span>
                            <span class="float-right font-bold text-gray-700 text-md">${{ number_format($amount+$transportation, 2) }}</span>
                        </div>
                    </div>

                    @include('livewire.cart.component.politics')

                    <div class="-mt-4">
                        <x-button-return route="{{ route('payment.delivery') }}">
                            {{ __('Delivery') }}
                        </x-button-return>
                    </div>
                </div>
            </div>
            <div id="divPaymentProccess" class="fixed inset-0 flex items-center justify-center hidden overflow-hidden fadeIn">
                <div class="absolute top-0 left-0 w-full h-full bg-gray-200 opacity-60"></div>
                <div class="absolute z-50 flex items-center px-6 py-6 text-center text-white bg-indigo-500 border rounded-md shadow-lg justicy-center">
                    <x-icon-spin class="mr-2" />
                    <div id="divNotify">{{__('Processing the payment')}}</div>
                </div>
            </div>
        </form>
    </div>

    @section('scripts')
        <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script type="text/javascript" src="{{ asset('js/toast.js') }}"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function(e) {
                //btn process payment
                const divPaymentProccess = document.getElementById('divPaymentProccess');
                const divNotify = document.getElementById('divNotify');
                const btnPayment = document.getElementById('paymentConfirm');
                const spinPayment = document.getElementById('spinPayment');
                const btnSubmit = document.getElementById('formData');
                //data form
                const orderNumber = document.getElementById('order_number');
                const amount = document.getElementById('amount');
                const transportation = document.getElementById('transportation');
                //div message validation data form
                const errorPayment = document.getElementById('error_payment');
                //function fetch
                const fetchData = async (url, method, data='') => {
                    var options = {
                        method: method,
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(data)
                    }
                    try {
                        const response = await fetch(url, options);
                        let data = await response.json();
                        return data;
                    } catch (error) {
                        return error;
                    }
                }
                //validate order fields (card + billing details are collected and validated by Stripe Elements itself)
                const validateForm = async () => {
                    let formData = {
                        order_number: orderNumber.value,
                        amount: parseFloat(amount.value) + parseFloat(transportation.value),
                    };
                    let response = await fetchData("{{ url('/api/validateform') }}", "POST", formData);
                    return response;
                }
                //set style view process payment
                const addStyle = () => {
                    spinPayment.classList.remove('hidden');
                    divPaymentProccess.classList.remove('hidden');
                    btnPayment.setAttribute('disabled', 'disabled');
                }
                const removeStyle = () => {
                    spinPayment.classList.add('hidden');
                    divPaymentProccess.classList.add('hidden');
                    btnPayment.removeAttribute('disabled');
                }
                //show error form validator
                const showErrorsValidatedForm = (errors) => {
                    errorPayment.innerHTML = Object.values(errors).flat().join('<br>');
                }

                @if($clientSecret)
                    //Stripe Elements setup
                    const stripe = Stripe("{{ $stripeKey }}");
                    const elements = stripe.elements({ clientSecret: "{{ $clientSecret }}" });
                    const paymentElement = elements.create('payment');
                    paymentElement.mount('#payment-element');

                    //begin process the payment
                    btnSubmit.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        errorPayment.innerHTML = '';
                        addStyle();
                        let validated = await validateForm();
                        if (!validated.status) {
                            removeStyle();
                            showErrorsValidatedForm(validated.errors);
                            toastInfo("{{ __('Field validation error') }}");
                            return;
                        }

                        divNotify.innerHTML = "{{ __('Completing the payment') }}";

                        const { error, paymentIntent } = await stripe.confirmPayment({
                            elements,
                            redirect: 'if_required',
                            confirmParams: {
                                return_url: "{{ url('/payment/confirm/' . $method) }}",
                            },
                        });

                        if (error) {
                            removeStyle();
                            errorPayment.innerHTML = error.message;
                            toastError(error.message);
                            return;
                        }

                        if (paymentIntent && paymentIntent.status === 'succeeded') {
                            toastSuccess("{{ __('The payment was made successfully') }}");
                            @this.paymentConfirm(paymentIntent.id);
                            dispatchEvent('refreshCart');
                            removeStyle();
                            window.location.href = "{{ url('/cart/cart-details') }}";
                            return;
                        }

                        removeStyle();
                        toastError("{{ __('An error has occurred') }}");
                    });
                @endif
            });
        </script>
    @endsection
</div>
