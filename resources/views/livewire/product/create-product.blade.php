<div class="p-6 bg-white rounded shadow space-y-6">

    <h1 class="text-2xl font-bold text-black mb-6">Nieuw product toevoegen</h1>

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- LEFT SIDE - TEXT FIELDS -->
        <div class="md:col-span-2 space-y-4">

            <!-- Naam -->
            <div>
                <label class="block mb-1 text-black">Naam</label>
                <input type="text" wire:model="name" class="border p-2 rounded w-full text-black">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Categorie -->
            <div>
                <label class="block mb-1 text-black">Categorie</label>
                <select wire:model="category_id" class="border p-2 rounded w-full text-black">
                    <option value="">Selecteer een categorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Omschrijving -->
            <div>
                <label class="block mb-1 text-black">Omschrijving</label>
                <textarea wire:model="description" class="border p-2 rounded w-full text-black"></textarea>
            </div>

            <!-- Gebruiker -->
            {{-- <div>
                <label class="block mb-1 text-black">Gebruiker</label>
                <select wire:model="user_id" class="border p-2 rounded w-full text-black">
                    <option value="">Selecteer een gebruiker</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div> --}}

            <!-- Prijs -->
            <div>
                <label class="block mb-1 text-black">Prijs (€)</label>
                <input type="number" step="0.01" wire:model="price" class="border p-2 rounded w-full text-black">
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Voorraad -->
            <div x-data="{ unlimitedStock: @entangle('unlimitedStock') }" x-effect="if(unlimitedStock){ $wire.set('stock', null) }">
                <div class="flex items-center space-x-2">
                    <input type="number" min="0" wire:model="stock" class="border p-2 rounded w-full text-black" :disabled="unlimitedStock" placeholder="Aantal voorraad">
                    <label class="flex items-center space-x-1">
                        <input type="checkbox" x-model="unlimitedStock">
                        <span>Onbeperkte voorraad</span>
                    </label>
                </div>
                @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-500 mt-1" x-text="unlimitedStock ? 'Voorraad is onbeperkt.' : 'Geef voorraad in.'"></p>
            </div>
        </div>

        <!-- RIGHT SIDE - IMAGES -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-black">Afbeeldingen</h2>

            <!-- Bestaande afbeeldingen -->
            <div class="grid grid-cols-3 gap-4">
                @foreach ($images as $index => $image)
                    <div class="relative group border rounded overflow-hidden">
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-32 object-cover">

                        <button type="button" wire:click="removeImage({{ $index }})"
                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                title="Verwijderen">
                            &times;
                        </button>
                    </div>
                @endforeach
            </div>


            <!-- Nieuwe afbeeldingen uploaden -->
            <div>
                <label class="block mb-1 text-black">Nieuwe afbeeldingen toevoegen</label>
                <label class="cursor-pointer border border-dashed border-gray-400 p-4 rounded flex items-center justify-center hover:bg-gray-100 text-gray-600 hover:text-black">
                    Klik hier om afbeeldingen te kiezen
                    <input type="file" wire:model="newImages" multiple class="hidden">
                </label>

                @error('newImages.*')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <!-- Submit Button -->
        <div class="md:col-span-3">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Opslaan</button>
        </div>

    </form>

</div>
