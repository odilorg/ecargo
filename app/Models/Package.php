<?php

namespace App\Models;


use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordCreatedNotification;


class Package extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::created(function ($package) {
            $user = $package->user; // Assuming a `user` relationship exists
            Mail::to('odilorg@gmail.com')->send(new RecordCreatedNotification($user, $package));
        });

        
    }
    
}
