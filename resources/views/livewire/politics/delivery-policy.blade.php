<div>
    <x-card>
        <x-card-header class="flex items-center">
            <div class="-mt-2 pb-2 text-lg font-bold text-gray-800">{{ __('Delivery Policy') }}</div>

            <button wire:click="$emit('closeModal')" type="button" class="float-right -mt-4 ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                <span class="sr-only">{{__('Cerrar')}}</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </x-card-header>
        <x-card-body>
            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('The delivery time is the number of business days (Monday-Friday) it takes to get the products purchased on the site to the final recipient, from our store.')}}
            </p>

            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('The distribution will be made in the national territory for sales made on the')}} <span class="font-bold uppercase text-green-700">Superbuy.cu</span> {{__('Site under the agreed terms and conditions.')}}
            </p>

            <p class="text-sm text-gray-700 text-justify">
                {{__('The delivery of the order to the receiver once the parcel is received, will be carried out in the following periods:')}}
            </p>

            <p class="mb-2 ml-4 text-sm text-gray-700 text-justify">
                - {{__('City of Las Tunas: from 7 to 14 business days.')}}
                <br>
                - {{__('Rest of the provinces: 12 to 20 business days')}}
            </p>

            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('The buyer (client) will receive a notification through his mail of the final delivery of the order to the receiver.')}}
            </p>

            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('Deliveries are made in a personalized way at the address of the recipient. If the addressee is not present at the time of the visit, the order will not be delivered to neighbors, friends or other people who are not duly indicated in the order by the client. The buyer (customer) may specify an alternative delivery name for this person to receive the order in case the original recipient is not present at the time the delivery is made.')}}
            </p>

            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('The recipient of the merchandise must check together with the distributor that the amounts declared in the invoice match the merchandise received. IF THEY DO NOT MATCH, YOU SHOULD NOT RECEIVE THE SHIPMENT. Once the invoice is signed and accepted, claims for missing products are not accepted.')}}
            </p>

            <p class="mb-2 text-sm text-gray-700 text-justify">
                {{__('
                This site reserves the right to modify this Delivery Policy at its discretion or against any client that is considered to have made an abusive use of it. Any revision or change will be binding, contractual, and effective immediately upon posting.')}}
            </p>

            <p class="text-sm text-gray-700 text-justify">
                {{__('You agree that you will periodically review this website, including the current version of our Delivery Policy. It is your obligation to review it for any changes or revisions.')}}
            </p>
        </x-card-body>
    </x-card>
</div>
