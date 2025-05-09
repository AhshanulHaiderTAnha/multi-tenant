<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product;

    // Product fields
    public $name;
    public $slug;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $images = [];

    // Extra fields
    public $categories;
    public $unlimitedStock = false;
    public $newImage;
    public $newCategory;

    public function addCategory()
    {
        $this->validate([
            'newCategory' => 'required|string|max:255'
        ]);

        $category = \App\Models\Category::create([
            'name' => $this->newCategory,
        ]);

        // Refresh categories + set category_id direct naar juiste ID (niet 'new')
        $this->categories = \App\Models\Category::all();
        $this->category_id = (string)$category->id; // <<< DIT (string zodat select updated wordt)
        $this->newCategory = null;

        // Force refresh on category_id to update select (optional but safer)
        $this->dispatch('categoryAdded');
    }



    public function mount(Product $product)
    {

        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->images = $product->photos; // <<< HIER GOED NU (photo models)

        $this->categories = \App\Models\Category::all();
        $this->unlimitedStock = is_null($product->stock);
    }

    public function updatedNewImage()
    {
        if ($this->newImage) {
            // Opslaan
            $path = $this->newImage->store('', 'public');

            // Foto opslaan in DB
            $this->product->photos()->create([
                'path' => $path,
                'alternate_text' => '',
            ]);

            // Direct vernieuwen (dit zorgt ervoor dat je DIRECT ziet)
            $this->product->refresh();
            $this->images = $this->product->photos;

            // Reset newImage
            $this->newImage = null;
        }
    }




    public function save()
    {
        // Check if category_id is "new" → dan eerst nieuwe aanmaken
        if ($this->category_id === 'new') {
            $this->validate([
                'newCategory' => 'required|string|max:255',
            ]);

            $category = \App\Models\Category::create([
                'name' => $this->newCategory,
            ]);

            // Update category_id naar de nieuwe ID
            $this->category_id = $category->id;

            // Refresh categories
            $this->categories = \App\Models\Category::all();

            // Reset newCategory input
            $this->newCategory = null;
        }

        $stock = $this->unlimitedStock ? null : $this->stock;

        $this->product->update([
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $stock,
            'images' => json_encode($this->product->photos->pluck('path')->toArray()),
            'category_id' => $this->category_id,
        ]);


        session()->flash('success', 'Product bijgewerkt!');
        return redirect()->route('products.index');
    }

    public function removeImage($photoId)
    {
        \App\Models\Photo::find($photoId)?->delete();

        // Direct opnieuw ophalen zodat meteen zichtbaar
        $this->product->refresh();
        $this->images = $this->product->photos;
    }



    public function updatedUnlimitedStock($value)
    {
        if ($value) {
            $this->stock = null;
        } else {
            $this->stock = 0; // als je wilt dat hij weer 0 wordt als je het vinkje uitzet
        }
    }




    public function render()
    {
        return view('livewire.product.edit-product');
    }
}
