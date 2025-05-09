<div class="p-6 bg-white rounded shadow space-y-4">

    <h1 class="text-2xl font-bold text-black mb-6">Orders</h1>

    @forelse ($orders as $order)
        <div class="flex items-center justify-between bg-gray-50 border rounded p-4 hover:bg-gray-100">
            <div class="space-y-1">

                <h2 class="font-semibold text-lg text-black">Order #{{ $order->id }} - €{{ number_format($order->order_total, 2, ',', '.') }}</h2>

                <p class="text-gray-500 text-sm">Status: <span class="font-semibold">{{ ucfirst($order->order_status) }}</span></p>
                <p class="text-gray-500 text-sm">Email: {{ $order->order_email }}</p>
                <p class="text-gray-500 text-sm">Datum: {{ $order->created_at->format('d-m-Y H:i') }}</p>

                <div class="text-gray-600 text-sm mt-2">
                    <p class="font-semibold">Items:</p>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($order->items as $item)
                            <li>
                                {{ $item->product->name ?? 'Product verwijderd' }} -
                                {{ $item->quantity }} x €{{ number_format($item->product_price, 2, ',', '.') }}
                                + €{{ number_format($item->product_taxes, 2, ',', '.') }} btw =
                                <strong>€{{ number_format($item->product_total, 2, ',', '.') }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Bekijken</a>
                <button wire:click="deleteOrder({{ $order->id }})" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Verwijderen</button>
            </div>
        </div>
    @empty
        <p class="text-gray-600">Geen orders gevonden.</p>
    @endforelse

</div>
