<?php

namespace App\Http\Livewire\Profile\MyOrder;

use App\Models\OrderStatus;
use Livewire\Component;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MyOrder extends Component
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

    public function render()
    {
        return view('livewire.profile.my-order.my-order', [
            'orders' => UserOrder::join('user_contacts', 'user_orders.user_contact_id', '=', 'user_contacts.id')
                            ->select('user_orders.*', 'user_contacts.name as contact_name', 'user_contacts.last_name as contact_last_name', 'user_contacts.dni as contact_dni')
                            ->when($this->order_status, function($query) {
                                $query->where('order_status_id', $this->order_status);
                            })
                            ->when($this->search, function($query) {
                                $query->where('user_orders.number', 'like', '%'.$this->search.'%')->where('user_orders.user_id',  $this->user->id);
                                $query->orWhere('user_contacts.name', 'like', '%'.$this->search.'%')->where('user_orders.user_id',  $this->user->id);
                                $query->orWhere('user_contacts.dni', 'like', '%'.$this->search.'%')->where('user_orders.user_id',  $this->user->id);
                            })
                            ->when($this->date, function($query) {
                                $query->where('user_orders.created_at', 'LIKE', '%'.$this->date.'%');
                            })
                            ->where('user_orders.user_id', $this->user->id)
                            ->latest()->paginate(10),
            'order_statuses' => OrderStatus::select('id', 'name')->get(),
        ]);
    }
}
