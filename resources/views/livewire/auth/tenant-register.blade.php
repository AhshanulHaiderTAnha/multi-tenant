<div class="w-full max-w-md p-6 bg-white rounded shadow">
    <form wire:submit.prevent="register" novalidate>
        <h2 class="text-2xl mb-4 text-center">Registreer je eigen subdomein</h2>

        <div class="mb-4">
            <label for="tenant_name">Bedrijfsnaam</label>
            <input wire:model.defer="tenant_name" id="tenant_name" class="w-full border p-2" />
            @error('tenant_name') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="tenant_domain">Kies je domein</label>
            <input wire:model.defer="tenant_domain" id="tenant_domain"
                   placeholder="bv. acme of acme.localhost"
                   class="w-full border p-2" />
            @error('tenant_domain') <p class="text-red-600">{{ $message }}</p> @enderror
            <small class="text-gray-600 block mt-1">
                “acme” → acme.localhost, of vul volledige hostname in.
            </small>
        </div>

        <div class="mb-4">
            <label for="name">Jouw naam</label>
            <input wire:model.defer="name" id="name" class="w-full border p-2" />
            @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email">E-mail</label>
            <input wire:model.defer="email" type="email" id="email" class="w-full border p-2" />
            @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password">Wachtwoord</label>
            <input wire:model.defer="password" type="password" id="password" class="w-full border p-2" />
            @error('password') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation">Bevestig wachtwoord</label>
            <input wire:model.defer="password_confirmation"
                   type="password" id="password_confirmation"
                   class="w-full border p-2" />
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded">
            Registreer en maak tenant
        </button>
    </form>
</div>
