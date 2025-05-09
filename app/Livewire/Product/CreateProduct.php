<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Photo;
use Livewire\WithFileUploads;
use App\Models\User;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $categories;
    public $users;
    public $unlimitedStock = false;

    public $newImages = [];
    public $images = [];
    public $product;

    public function mount()
    {
        $this->categories = Category::all();
        $this->users = User::all();
    }

    public function updatedNewImages()
    {
        foreach ($this->newImages as $image) {
            $this->images[] = $image; // <-- gewoon file opslaan, geen array maken
        }

        $this->newImages = [];
    }




    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }


    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'stock' => $this->unlimitedStock ? 'nullable' : 'required|integer|min:0',
        ]);

        $stock = $this->unlimitedStock ? null : $this->stock;

        // Product aanmaken als nog niet bestaat
        if (!$this->product) {
            $this->product = Product::create([
                'name' => $this->name,
                'slug' => \Str::slug($this->name) . '-' . uniqid(),
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $stock,
                'category_id' => $this->category_id,
                'tenant_id' => auth()->user()->tenant_id,
            ]);
        }

        // Upload afbeeldingen nu PAS en sla op in database
        foreach ($this->images as $file) {

            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $filename, 'public');

            $this->product->photos()->create([
                'path' => $filename,
                'alternate_text' => '',
            ]);
        }

        $this->product->update([
            'images' => json_encode($this->product->photos->pluck('path')->toArray())
        ]);

        session()->flash('success', 'Product toegevoegd!');
        return redirect()->route('products.index');
    }


    public function updatedUnlimitedStock($value)
    {
        $this->stock = $value ? null : 0;
    }

    public function render()
    {
        return view('livewire.product.create-product');
    }
}
