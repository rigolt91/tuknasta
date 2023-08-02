<div x-data="{open: false}" class="my-8">
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
                                <div class="w-full mb-2 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="first_name" :value="__('Name')" />
                                        <x-input name="first_name" id="first_name" wire:model.lazy='first_name' type="text"
                                            class="block w-full mt-1" :value="old('first_name', $first_name)"
                                            placeholder="{{ __('First name') }}" autocomplete="first_name" />
                                    </div>
                                    <x-input-error class="mt-2" for="first_name" />
                                </div>

                                <div class="w-full mb-2 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="last_name" :value="__('Last name')" />
                                        <x-input name="last_name" id="last_name" wire:model.lazy='last_name' type="text"
                                            class="block w-full mt-1" :value="old('last_name', $last_name)"
                                            placeholder="{{ __('Last name') }}" autocomplete="last_name" />
                                    </div>
                                    <x-input-error class="mt-2" for="last_name" />
                                </div>
                            </div>

                            <div class="mt-2 sm:flex">
                                <div class="w-full mb-2 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="address" :value="__('Address')" />
                                        <x-input name="address" id="address" wire:model.lazy='address' type="text"
                                            class="block w-full mt-1" :value="old('address', $address)"
                                            placeholder="{{ __('Address') }}" autocomplete="address" />
                                    </div>
                                    <x-input-error class="mt-2" for="address" />
                                </div>

                                <div class="w-full mb-2 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="postal_code" :value="__('Postal code')" />
                                        <x-input name="postal_code" id="postal_code" wire:model.lazy='postal_code' type="text"
                                            class="block w-full mt-1" :value="old('postal_code', $postal_code)"
                                            placeholder="{{ __('Postal code') }}" autocomplete="postal_code" />
                                    </div>
                                    <x-input-error class="mt-2" for="postal_code" />
                                </div>
                            </div>


                            <div class="mt-2 sm:flex">
                                <div class="w-full mb-4">
                                    <div class="relative">
                                        <x-label for="card_number" :value="__('Card number')" />
                                        <x-input name="card_number" id="card_number" wire:model.lazy='card_number' type="text"
                                            class="block w-full mt-1" :value="old('card_number', $card_number)"
                                            placeholder="{{ __('Card number') }}" autocomplete="card_number" />
                                    </div>
                                    <x-input-error class="mt-2" for="card_number" />
                                </div>
                            </div>

                            <div class="sm:flex">
                                <div class="w-full mb-4 sm:mr-2">
                                    <div class="relative">
                                        <x-label for="cvv2cvv2" :value="__('CVV')" />
                                        <x-input name="cvv2cvv2" id="cvv2cvv2" wire:model.lazy='cvv2cvv2' type="text" min="1"
                                            class="block w-full mt-1" :value="old('cvv2cvv2', $cvv2cvv2)"
                                            placeholder="{{ __('Security code') }}" autocomplete="cvv2cvv2" />
                                    </div>
                                    <x-input-error class="ml-2" for="cvv2cvv2" />
                                </div>

                                <div class="w-full mb-4 sm:ml-2">
                                    <div class="relative">
                                        <x-label for="exp_date" :value="__('Expiry date (MM/YY)')" />
                                        <x-input name="exp_date" id="exp_date" wire:model.lazy="exp_date" type="text"
                                            class="block w-full mt-1" maxlength="5" :value="old('exp_date', $exp_date)"
                                            placeholder="{{ __('MM/YY') }}" autocomplete="exp_date" />
                                    </div>
                                    <x-input-error class="mt-2" for="exp_date" />
                                </div>
                            </div>

                            <div class="sm:flex">
                                <x-input type="hidden" id="amount" wire:model="amount" class="sm:mr-2" />
                                <x-input type="hidden" id="order_number" wire:model="order_number" class="sm:ml-2" />
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
                    <x-button id="paymentConfirm" @click="open = false" type="submit" wire:loading.attr="disabled"
                        class="w-full mb-4 rounded-none disabled:opacity-60 sm:rounded">
                        <svg fill="currentColor" class="h-5 mr-2 bi bi-credit-card-2-back-fill" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5H0V4zm11.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zM0 11v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1H0z" />
                        </svg>
                        {{ __('Confirmar') }}
                        <div class="flex justify-end w-full">
                            <x-icon-spin wire:loading wire:target="paymentConfirm" class="ml-1" />
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

            <div x-show="open" class="bg-gray-200 opacity-60 absolute w-full h-full top-0 left-0"></div>
            <div
                    x-show="open"
                    x-transition.duration.500ms
                    id="notify"
                    class="absolute z-50 top-1/2 left-1/2 bg-green-500 text-white shadow-lg border py-6 px-6 rounded-md flex items-center justicy-center text-center">
                    <x-icon-spin class="mr-2" />
                    {{ __('Procesando el Pago')}}
                </div>
        </form>
    </div>

    @section('scripts')
        <script type="text/javascript" src="https://libs.fraud.elavongateway.com/sdk-web-js/1.2.0/3ds2-web-sdk.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/geoinfo.js') }}"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function(e) {
                const getExpiry = (reverse = false) => {
                    var expMM = document.getElementById("exp_date").value.substring(0, 2);
                    var expYY = document.getElementById("exp_date").value.substring(3, 5);
                    return reverse ? expYY.concat(expMM) : expMM.concat(expYY);
                };

                const getEFSEci = (eci) => {
                    if (eci === '01' || eci === '05') {
                        return '5';
                    } else if (eci === '02' || eci === '06') {
                        return '6';
                    } else {
                        return '7';
                    }
                };

                const getEfsToken = async () => {
                    try {
                        const response = await fetch("{{ url('/api/efstoken') }}");
                        var data;
                        if (response.ok) {
                            data = await response.json();
                            return data['3ds2_token'];
                        }
                    } catch (error) {
                        return error;
                    }
                }

                bypass3ds2Country = ['CU', 'UNKNOWN'];

                const performVerify = async () => {
                    try {
                        var formData = {
                            card_number: document.getElementById('card_number').value,
                            exp_date: getExpiry(),
                            first_name: document.getElementById('first_name').value,
                            last_name: document.getElementById('last_name').value,
                            cvv2cvv2: document.getElementById('cvv2cvv2').value,
                            avs_address: document.getElementById('address').value,
                            avs_zip: document.getElementById('postal_code').value,
                        }

                        const response = await fetch("{{ url('/api/verify') }}", {
                            method: 'POST',
                            headers: {
                                'Accept': 'application.json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(formData),
                        });

                        var data;
                        if (response.ok) {
                            data = await response.json();
                            return data;
                        }
                    } catch (error) {
                        return error;
                    }
                }

                const paymentWithout3DS2 = async () => {
                    try {
                        var formData = {
                            amount: document.getElementById('amount').value,
                            card_number: document.getElementById('card_number').value,
                            exp_date: getExpiry(),
                            cvv2cvc2: document.getElementById('cvv2cvv2').value,
                            description: 'Payment for Order ' + document.getElementById('order_number').value,
                            merchant_txn_id: document.getElementById('order_number').value,
                            avs_address: document.getElementById('address').value,
                            avs_zip: document.getElementById('postal_code').value,
                        };

                        const response = await fetch("{{ url('/api/sale') }}", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: JSON.stringify(formData),
                        });
                        var data;
                        if (response.ok) {
                            data = await response.json();
                            return data;
                        }
                    } catch (error) {
                        return error;
                    }
                }

                const paymentWith3DS2 = async () => {
                    try {
                        var efsUrl = "https://gw.fraud.elavongateway.com/3ds2";
                        var efsToken = await getEfsToken();

                        var sdk = new window.Elavon3DSWebSDK({
                            baseUrl: efsUrl,
                            token: efsToken,
                            el: 'holder'
                        });

                        var request = {
                            purchaseAmount: parseInt(document.getElementById('amount').value * 100),
                            purchaseCurrency: "840",
                            purchaseExponent: "2",
                            acctNumber: document.getElementById('card_number').value,
                            cardExpiryDate: getExpiry(true),
                            messageCategory: "01",
                            transType: "01",
                            threeDSRequestorAuthenticationInd: "01",
                            challengeWindowSize: "03",
                            clientStartProtocolVersion: "2.1.0",
                            clientEndProtocolVersion: "2.2.0",
                            displayMode: "lightbox",
                            avs_address: document.getElementById('address').value,
                            avs_zip: document.getElementById('postal_code').value,
                        };

                        sdk.web3dsFlow(request).then(function success(response) {
                            var formData = {
                                amount: document.getElementById('amount').value,
                                card_number: document.getElementById('card_number').value,
                                exp_date: getExpiry(),
                                cvv2cvc2: document.getElementById('cvv2cvv2').value,
                                description: 'Payment for Order ' + document.getElementById('order_number')
                                    .value,
                                merchant_txn_id: orderId,
                                avs_address: document.getElementById('address').value,
                                avs_zip: document.getElementById('postal_code').value,
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
                                let response = await fetch("{{ url('/api/sale') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: JSON.stringify(formData),
                                });

                                var data;
                                if (response.ok) {
                                    data = await response.json();
                                    return data;
                                }
                            })();
                        }, function error(response) {
                            return response;
                        });
                    } catch (error) {
                        return error;
                    }
                }

                const validateForm = async () => {
                    let formData = {
                        first_name:document.getElementById('first_name').value,
                        last_name:document.getElementById('last_name').value,
                        address: document.getElementById('address').value,
                        postal_code: document.getElementById('postal_code').value,
                        order_number: document.getElementById('order_number').value,
                        card_number: document.getElementById('card_number').value,
                        exp_date: document.getElementById('exp_date').value,
                        cvv2cvv2: document.getElementById('cvv2cvv2').value,
                        amount: document.getElementById('amount').value,
                    };

                    let response = await fetch("{{ url('/api/validateform') }}", {
                        method: "POST",
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json'
                        },
                        body: JSON.stringify(formData),
                    });

                    var data;

                    if (response.ok) {
                        data = await response.json();

                        console.log(data);
                    } else {
                        console.log('error');
                    }
                }

                let form = document.getElementById('formData');

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    validateForm();

                    /*const verify = await performVerify();

                    console.log(verify);

                    if (verify.errorCode) {
                        console.log(`Error verify ${verify.errorCode}: ${verify.errorMessage}`);
                        return false;
                    }

                    if (verify && typeof verify.result === 'string' && verify.result === '0') {
                        console.log('Verify');
                        (async () => {
                            try {
                                if(bypass3ds2Country.includes(geoInfo.countryCode)) {
                                    const paymentResult = await paymentWithout3DS2();
                                } else {
                                    const paymentResult = await paymentWith3DS2();
                                }

                                if (paymentResult.errorCode) {
                                    console.log(
                                        `Error payment ${paymentResult.errorCode}: ${paymentResult.errorMessage}`
                                    );
                                    return;
                                }

                                if (paymentResult && typeof paymentResult.result === 'string' &&
                                    paymentResult.result === '0') {
                                    window.location.href = "{{ url('/cart/cart-details') }}";
                                } else {
                                    console.log('Error: {{ __('response.somethingWentWrong') }}');
                                }
                            } catch (error) {
                                return error;
                            }
                        })();
                    } else {
                        console.log('Not Verify');
                    }*/

                });
            });
        </script>
    @endsection
</div>
