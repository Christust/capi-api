<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'address', 'city', 'state', 'country', 'postal_code'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
