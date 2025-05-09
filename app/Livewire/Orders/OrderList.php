<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;

class OrderList extends Component
{
    public $orders;

    public function mount()
    {
        // Laad alle orders inclusief hun order items
        $this->orders = Order::with('items')->latest()->get();
    }
    public function render()
    {
        return view('livewire.orders.order-list');
    }
}
