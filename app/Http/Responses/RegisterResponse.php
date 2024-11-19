<?php
namespace App\Http\Responses;
 
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use App\Filament\Resources\OrderResource;
use Livewire\Features\SupportRedirects\Redirector;
 
class RegisterResponse extends \Filament\Http\Responses\Auth\RegistrationResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
         // You can use the Filament facade to get the current panel and check the ID
         if (Filament::getCurrentPanel()->getId() === 'odilorg') {
            return redirect('/odilorg');
        }
 
        if (Filament::getCurrentPanel()->getId() === 'client') {
            return redirect('/client/edit-profile');
        }
 
        return parent::toResponse($request);
    }
}