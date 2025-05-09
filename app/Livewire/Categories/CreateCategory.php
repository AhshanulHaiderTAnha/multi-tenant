<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str; // Bovenaan toevoegen


class CreateCategory extends Component
{
    public string $name = '';

    protected array $rules = [
        'name' => 'required|min:2|unique:categories,name'
    ];

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name), // 👈 DIT IS WAT ONTBREEKT !!!
        ]);

        session()->flash('success', 'Categorie toegevoegd!');

        return redirect()->route('categories.index');
    }


    public function render()
    {

        $user = auth()->user();
        if ($user && is_null($user->tenant_id)) {
            return view('livewire.categories.create-category');
        }else{
            abort(403, 'No permission to access this page.');
        }
        
    }
}
