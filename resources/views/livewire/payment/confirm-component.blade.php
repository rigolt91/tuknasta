<div class="my-8">
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
                            <div class="mt-4 sm:flex">
                                <div class="w-full mb-4 sm:mb-2 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="first_name" :value="__('Name')" />
                                        <x-input name="first_name" id="first_name" wire:model.lazy='first_name'
                                            type="text" class="block w-full mt-1" :value="old('first_name', $first_name)"
                                            placeholder="{{ __('First name') }}" autocomplete="first_name" />
                                    </div>
                                    <div id="error_first_name" class="mt-2 text-sm text-red-600"></div>
                                </div>

                                <div class="w-full mb-4 sm:mb-2 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="last_name" :value="__('Last name')" />
                                        <x-input name="last_name" id="last_name" wire:model.lazy='last_name'
                                            type="text" class="block w-full mt-1" :value="old('last_name', $last_name)"
                                            placeholder="{{ __('Last name') }}" autocomplete="last_name" />
                                    </div>
                                    <div id="error_last_name" class="mt-2 text-sm text-red-600"></div>
                                </div>
                            </div>

                            <div class="mt-2 sm:flex">
                                <div class="w-full mb-4 sm:mb-2 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="address" :value="__('Address')" />
                                        <x-input name="address" id="address" wire:model.lazy='address' type="text"
                                            class="block w-full mt-1" :value="old('address', $address)"
                                            placeholder="{{ __('Address') }}" autocomplete="address" />
                                    </div>
                                    <div id="error_address" class="mt-2 text-sm text-red-600"></div>
                                </div>

                                <div class="w-full mb-4 sm:mb-2 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="postal_code" :value="__('Postal code')" />
                                        <x-input name="postal_code" id="postal_code" wire:model.lazy='postal_code'
                                            type="text" class="block w-full mt-1" :value="old('postal_code', $postal_code)"
                                            placeholder="{{ __('Postal code') }}" autocomplete="postal_code" />
                                    </div>
                                    <div id="error_postal_code" class="mt-2 text-sm text-red-600"></div>
                                </div>
                            </div>


                            <div class="mt-2 sm:flex">
                                <div class="w-full mb-4">
                                    <div class="relative">
                                        <x-label for="card_number" :value="__('Card number')" />
                                        <x-input name="card_number" id="card_number" wire:model.lazy='card_number'
                                            type="text" class="block w-full mt-1" :value="old('card_number', $card_number)"
                                            placeholder="{{ __('Card number') }}" autocomplete="card_number" />
                                    </div>
                                    <div id="error_card_number" class="mt-2 text-sm text-red-600"></div>
                                </div>
                            </div>

                            <div class="sm:flex">
                                <div class="w-full mb-4 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="cvv2cvc2" :value="__('CVV')" />
                                        <x-input name="cvv2cvc2" id="cvv2cvc2" wire:model.lazy='cvv2cvc2'
                                            type="text" min="1" class="block w-full mt-1" :value="old('cvv2cvc2', $cvv2cvc2)"
                                            placeholder="{{ __('Security code') }}" autocomplete="cvv2cvc2" />
                                    </div>
                                    <div id="error_cvv2cvc2" class="mt-2 text-sm text-red-600"></div>
                                </div>

                                <div class="w-full mb-4 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="exp_date" :value="__('Expiry date (MM/YY)')" />
                                        <x-input name="exp_date" id="exp_date" wire:model.lazy="exp_date"
                                            type="text" class="block w-full mt-1" maxlength="5" :value="old('exp_date', $exp_date)"
                                            placeholder="{{ __('MM/YY') }}" autocomplete="exp_date" />
                                    </div>
                                    <div id="error_exp_date" class="mt-2 text-sm text-red-600"></div>
                                </div>
                            </div>

                            <div class="sm:flex">
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
                        {{ __('Confirmar') }}
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

                    @include('livewire.cart.component.total-cost')

                    @include('livewire.cart.component.politics')

                    <div class="-mt-4">
                        <x-button-return route="{{ route('payment.delivery') }}">
                            {{ __('Delivery') }}
                        </x-button-return>
                    </div>
                </div>
            </div>
            <div id="divPaymentProccess" class="fixed inset-0 hidden overflow-hidden fadeIn">
                <div class="absolute top-0 left-0 w-full h-full bg-gray-200 opacity-60"></div>
                <div
                    class="absolute z-50 flex items-center px-6 py-6 text-center text-white bg-green-500 border rounded-md shadow-lg top-1/2 left-1/2 justicy-center">
                    <x-icon-spin class="mr-2" />
                    <div id="divNotify">{{__('Processing the payment')}}</div>
                </div>
            </div>
        </form>
    </div>

    @section('scripts')
        <script type="text/javascript" src="https://libs.fraud.elavongateway.com/sdk-web-js/1.2.0/3ds2-web-sdk.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script type="text/javascript" src="{{ asset('js/toast.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/geoinfo.js') }}"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function(e) {
                //btn process payment
                const divPaymentProccess = document.getElementById('divPaymentProccess');
                const divNotify = document.getElementById('divNotify');
                const btnPayment = document.getElementById('paymentConfirm');
                const spinPayment = document.getElementById('spinPayment');
                const btnSubmit = document.getElementById('formData');
                //data form
                const expDate = document.getElementById("exp_date");
                const cardNumber = document.getElementById('card_number');
                const firstName = document.getElementById('first_name');
                const lastName = document.getElementById('last_name');
                const cvv2cvc2 = document.getElementById('cvv2cvc2');
                const address = document.getElementById('address');
                const postalCode = document.getElementById('postal_code');
                const orderNumber = document.getElementById('order_number');
                const amount = document.getElementById('amount');
                //div message validation data form
                const errorFirstName = document.getElementById('error_first_name');
                const errorLastName =  document.getElementById('error_last_name');
                const errorAddress = document.getElementById('error_address');
                const errorCardNumber = document.getElementById('error_card_number');
                const errorCvvCv2 = document.getElementById('error_cvv2cvc2');
                const errorExpDate = document.getElementById('error_exp_date');
                const errorPostalCode = document.getElementById('error_postal_code');
                //function fetch
                const fetchData = async (url, method, data='') => {
                    var options = {
                        method: method,
                        headers: {
                            'Accept': 'application.json',
                            'Content-Type': 'application/json'
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
                //format expiry date
                const getExpiry = (reverse = false) => {
                    var expMM = expDate.value.substring(0, 2);
                    var expYY = expDate.value.substring(3, 5);
                    return reverse ? expYY.concat(expMM) : expMM.concat(expYY);
                };
                //return value EFSECI
                const getEFSEci = (eci) => {
                    if (eci === '01' || eci === '05') {
                        return '5';
                    } else if (eci === '02' || eci === '06') {
                        return '6';
                    } else {
                        return '7';
                    }
                };
                //get efsToken for payment 3dsecure
                const getEfsToken = async () => {
                    try {
                        const response = await fetchData("{{ url('/api/efstoken') }}", "GET");
                        return response['3ds2_token'];
                    } catch (error) {
                        return error;
                    }
                }
                //country view site default
                bypass3ds2Country = ['CU', 'UNKNOWN'];
                //verify card data
                const performVerify = async () => {
                    try {
                        var formData = {
                            card_number: cardNumber.value,
                            exp_date: getExpiry(),
                            cvv2cvc2: cvv2cvc2.value,
                            avs_address: address.value,
                            avs_zip: postalCode.value,
                        }
                        const response = await fetchData("{{ url('/api/verify') }}", "POST", formData);
                        return response;
                    } catch (error) {
                        return error;
                    }
                }
                //payment without 3dsecure
                const paymentWithout3DS2 = async () => {
                    try {
                        let amountOrder = parseFloat(amount.value);
                        var formData = {
                            amount: amountOrder.toFixed(2),
                            card_number: cardNumber.value,
                            first_name: firstName.value,
                            last_name: lastName.value,
                            exp_date: getExpiry(),
                            cvv2cvc2: cvv2cvc2.value,
                            description: `Payment for Order ${orderNumber.value}`,
                            merchant_txn_id: orderNumber.value,
                            avs_address: address.value,
                            avs_zip: postalCode.value,
                        };
                        const response = await fetchData("{{ url('/api/sale') }}", "POST", formData);
                        return response;
                    } catch (error) {
                        return error;
                    }
                }
                //payment with 3dsecure
                const paymentWith3DS2 = async () => {
                    try {
                        var efsUrl = "https://gw.fraud.elavongateway.com/3ds2";
                        var efsToken = await getEfsToken();
                        var sdk = new window.Elavon3DSWebSDK({
                            baseUrl: efsUrl,
                            token: efsToken,
                            el: 'holder'
                        });
                        let amountOrder = parseFloat(amount.value);
                        var request = {
                            purchaseAmount: parseInt(amountOrder.toFixed(2) * 100),
                            acctNumber: cardNumber.value,
                            first_name: firstName.value,
                            last_name: lastName.value,
                            cardExpiryDate: getExpiry(true),
                            avs_address: address.value,
                            avs_zip: postalCode.value,
                            purchaseCurrency: "840",
                            purchaseExponent: "2",
                            messageCategory: "01",
                            transType: "01",
                            threeDSRequestorAuthenticationInd: "01",
                            challengeWindowSize: "03",
                            clientStartProtocolVersion: "2.1.0",
                            clientEndProtocolVersion: "2.2.0",
                            displayMode: "lightbox",
                        };
                        sdk.web3dsFlow(request).then(function success(response) {
                            var formData = {
                                amount: amountOrder.toFixed(2),
                                card_number: cardNumber.value,
                                exp_date: getExpiry(),
                                cvv2cvc2: cvv2cvc2.value,
                                description: `Payment for Order ${orderNumber.value}`,
                                merchant_txn_id: orderNumber.value,
                                avs_address: address.value,
                                avs_zip: postalCode.value,
                                eci_ind: getEFSEci(response.eci),
                                program_protocol: 2,
                            };
                            if (response.authenticationValue) {
                                formData['3dsecure_value'] = response.authenticationValue;
                            }
                            if (response.dsTransID) {
                                formData['dir_server_tran_id'] = response.dsTransID;
                            }
                            if (response.threeDSServerTransID) {
                                formData['3ds_server_trans_id'] = response.threeDSServerTransID;
                            }
                            if (response.transStatus) {
                                formData['3ds_trans_status'] = response.transStatus;
                            }
                            if (response.transStatusReason) {
                                formData['3ds_trans_status_reason'] = response.transStatusReason;
                            }
                            if (response.messageVersion) {
                                formData['3ds_message_version'] = response.messageVersion;
                            }
                            (async () => {
                                let response = await fetchData("{{ url('/api/sale') }}", "POST", formData);
                                return response;
                            })();
                        }, function error(response) {
                            return response;
                        });
                    } catch (error) {
                        return error;
                    }
                }
                //validate form data
                const validateForm = async () => {
                    let formData = {
                        first_name: firstName.value,
                        last_name: lastName.value,
                        address: address.value,
                        postal_code: postalCode.value,
                        order_number: orderNumber.value,
                        card_number: cardNumber.value,
                        exp_date: expDate.value,
                        cvv2cvc2: cvv2cvc2.value,
                        amount: amount.value,
                    };
                    let response = await fetchData("{{ url('/api/validateform') }}", "POST", formData);
                    return response;
                }
                //set style view process payment
                const setStyle = () => {
                    spinPayment.classList.toggle('hidden');
                    divPaymentProccess.classList.toggle('hidden');
                }
                //begin process the payment
                btnSubmit.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    setStyle();
                    btnPayment.toggleAttribute('disabled');
                    let validated = await validateForm();
                    if (!validated.status) {
                        setStyle();
                        btnPayment.toggleAttribute('disabled', '');
                        showErrorsValidatedForm(validated.errors);
                        toastInfo("{{ __('Field validation error') }}");
                        return;
                    } else {
                        divNotify.innerHTML = "{{ __('Verifying card information') }}";
                        const verify = await performVerify();
                        if (verify && typeof verify.result === 'string' && verify.result === '0') {
                            divNotify.innerHTML = "{{ __('Completing the payment') }}";
                            (async () => {
                                try {
                                    if (bypass3ds2Country.includes(geoInfo.countryCode)) {
                                        const paymentResult = await paymentWithout3DS2();
                                    } else {
                                        const paymentResult = await paymentWith3DS2();
                                    }
                                    if (paymentResult.errorCode) {
                                        setStyle();
                                        btnPayment.toggleAttribute('disabled', '');
                                        toastError(`Error payment ${paymentResult.errorCode}: ${paymentResult.errorMessage}`);
                                        return;
                                    }
                                    if (paymentResult && typeof paymentResult.result === 'string' && paymentResult.result === '0')
                                    {
                                        setStyle();
                                        btnPayment.toggleAttribute('disabled', '');
                                        toastSuccess("{{ __('The payment was made successfully') }}");
                                        @this.paymentConfirm();
                                        window.location.href = "{{ url('/cart/cart-details') }}";
                                    } else {
                                        setStyle();
                                        btnPayment.toggleAttribute('disabled', '');
                                        toastError("{{ __('An error has occurred') }}: {{ __('response.somethingWentWrong') }}");
                                    }
                                } catch (error) {
                                    setStyle();
                                    btnPayment.toggleAttribute('disabled', '');
                                    toastError(`${error}`);
                                }
                            })();
                        } else {
                            setStyle();
                            btnPayment.toggleAttribute('disabled', '');
                            toastError("{{ __('Card verification error') }}");
                        }
                    }
                });
                //show error form validator
                const showErrorsValidatedForm = (errors) => {
                    errors.first_name ? errorFirstName.innerHTML = errors.first_name : '';
                    errors.last_name ? errorLastName.innerHTML = errors.last_name : '';
                    errors.address ? errorAddress.innerHTML = errors.address : '';
                    errors.card_number ? errorCardNumber.innerHTML = errors.card_number : '';
                    errors.cvv2cvc2 ? errorCvvCv2.innerHTML = errors.cvv2cvc2 : '';
                    errors.exp_date ? errorExpDate.innerHTML = errors.exp_date : '';
                    errors.postal_code ? errorPostalCode.innerHTML = errors.postal_code : '';
                }
            });
        </script>
    @endsection
</div>
