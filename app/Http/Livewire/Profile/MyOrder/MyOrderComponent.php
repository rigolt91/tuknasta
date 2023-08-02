<?php

namespace App\Http\Livewire\Profile\MyOrder;

use App\Models\OrderStatus;
use Livewire\Component;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MyOrderComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $order_status = '';
    public $date;
    public $user;

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function mount(Request $request)
    {
        $this->search = $request->search;
        $this->user = Auth::user();
    }

    public function show($order)
    {
        $this->emit('openModal', 'admin-panel.order.show-component', ['order' => $order]);
    }

    public function render()
    {
        return view('livewire.profile.my-order.my-order-component', [
            'orders' => UserOrder::joinUserContact()
            ->whereStatus($this->order_status)
            ->whereNumber($this->search)
            ->whereDate($this->date)
            ->whereContact($this->search)
            ->whereUser($this->user->id)
            ->latest()
            ->paginate(10),
            'order_statuses' => OrderStatus::get(),
        ]);
    }
}
