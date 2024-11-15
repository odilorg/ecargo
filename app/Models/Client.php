<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

}
