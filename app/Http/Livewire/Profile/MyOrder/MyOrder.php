<?php

namespace App\Http\Livewire\Profile\MyOrder;

use Livewire\Component;
use App\Models\UserOrder;
use Livewire\WithPagination;

class MyOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $total_cost;

    public function orderDetails($order)
    {
        return redirect()->route('profile.my-orders.details', $order);
    }

    public function render()
    {
        return view('livewire.profile.my-order.my-order', [
            'user_orders' => UserOrder::where('number', 'LIKE', '%'.$this->search.'%')->latest()->paginate(5),
        ]);
    }
}
