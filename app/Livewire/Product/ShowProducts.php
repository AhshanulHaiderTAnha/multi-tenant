<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class ShowProducts extends Component
{
    public $products;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = Product::query();

        // Multi-tenancy filter
        $tenantId = auth()->user()?->tenant_id;

        if ($tenantId) {
            $query->where('tenant_id', $tenantId)->whereNotNull('tenant_id');
        }

        // Fix: use $query->with(...) instead of $query::with(...)
        $this->products = $query->with('photos')->get();
    }


    public function delete($productId)
    {
        $product = Product::findOrFail($productId);

        // Alleen softdelete (zodat hij hersteld kan worden)
        $product->delete();

        // Refresh lijst
        $this->loadProducts();

        session()->flash('success', 'Product tijdelijk verwijderd.');
    }
    public function confirmDelete($productId)
    {
        if (! $product = Product::find($productId)) {
            session()->flash('error', 'Product niet gevonden.');
            return;
        }

        $product->delete();
        $this->loadProducts();
        session()->flash('success', 'Product tijdelijk verwijderd.');
    }


    public function deleteProduct($productId)
    {
        Product::findOrFail($productId)->delete();
        $this->loadProducts();
        session()->flash('success', 'Product verwijderd!');
    }


    public function render()
    {
        return view('livewire.product.show-products', [
            'products' => $this->products
        ]);
    }
}
