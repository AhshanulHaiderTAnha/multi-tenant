<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Auth\Events\Registered;
use DB;


class TenantRegister extends Component
{
    public $tenant_name, $tenant_domain, $name, $email, $password, $password_confirmation;

    protected function rules()
    {
        return [
            'tenant_name'   => 'required|string|max:50|unique:tenants,id',
            'tenant_domain' => 'required|string|max:100|unique:domains,domain',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
        ];
    }

    public function register()
    {
        $this->validate();

        $slug  = Str::slug($this->tenant_name);
        $input = trim($this->tenant_domain);

        // $host = Str::contains($input, '.')
        //     ? $input
        //     : Str::slug($input).'.'.config('tenancy.central_domains')[0];
        $host = Str::contains($input, '.')
            ? $input
            : Str::slug($input).'.'.'localhost';

        // **Let hier op**: gebruik de façade, niet tenancy() helper
        $tenant = Tenant::create([
            'slug' => $slug,
            'data' => [],
        ]);

        $tenant->domains()->create([
            'domain' => $host,
        ]);

        // Create the user inside the tenant's context
        $tenant->run(function () use ($tenant) {
            $user = User::create([
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'tenant_id' => $tenant->id,
            ]);
            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => "App\Models\User",
                'model_id' => $user->id
            ]);
            Auth::login($user);
        });
        
        // Redirect to the tenant-specific domain dashboard
        $scheme = request()->getScheme(); // http or https
        $dashboardUrl = $scheme . '://' . $host . '/dashboard';

        return redirect()->to($dashboardUrl);
        
    }

    public function render()
    {
        return view('livewire.auth.tenant-register')->layout('layouts.guest');

    }
}

