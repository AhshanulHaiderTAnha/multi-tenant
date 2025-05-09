<div class="p-6 bg-white rounded shadow space-y-4" x-data="{ confirmDeleteId: null }">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-black">Producten</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Nieuw product
        </a>
    </div>

    @forelse ($products as $product)
        <div class="flex items-center justify-between bg-gray-50 border rounded p-4 hover:bg-gray-100">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gray-300 flex items-center justify-center rounded overflow-hidden">
                    @if ($product->photos->first())
                        <img src="{{ asset('assets/img/'.$product->photos->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        📦
                    @endif
                </div>

                <div>
                    <h2 class="font-semibold text-lg text-black">{{ $product->name }}</h2>
                    <p class="text-gray-600 font-bold">€{{ number_format($product->price, 2, ',', '.') }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $product->description }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">View</button>
                <a href="{{ route('products.edit', $product->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>

                <button @click="confirmDeleteId = {{ $product->id }}" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                    Verwijderen
                </button>
            </div>
        </div>
    @empty
        <p class="text-gray-600">Geen producten gevonden.</p>
    @endforelse

    <!-- Confirm Modal (mooiere variant) -->
    <div
        x-show="confirmDeleteId"
        class="fixed inset-0 flex items-center justify-center bg-white/60 backdrop-blur-md z-50"
        style="display: none;"
        x-transition
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Bevestig verwijdering</h2>
            <p class="text-gray-600">Weet je zeker dat je dit product wilt verwijderen?</p>
            <div class="flex justify-end space-x-3">
                <button
                    @click="$wire.call('deleteProduct', confirmDeleteId); confirmDeleteId = null;"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Verwijderen
                </button>
                <button
                    @click="confirmDeleteId = null"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                    Annuleren
                </button>
            </div>
        </div>
    </div>
</div>
