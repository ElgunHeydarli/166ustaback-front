<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'phone', 'service_id', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
