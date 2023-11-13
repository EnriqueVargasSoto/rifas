<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function order_images()
    {
        return $this->hasMany(OrderImage::class, 'order_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }


    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->orWhere('orders.total', 'like', '%' . $search . '%')
                ->orWhereRaw("CONCAT(clients.name,' ',clients.last_name) LIKE '%$search%'")
                ->orWhere('clients.phone', 'like', '%' . $search . '%')
                ->orWhere('orders.status', 'like', '%' . $search . '%');
        }

        return $query;
    }
}
