<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationStatusEvent extends Model
{
    use HasFactory;
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function reservationStatusCatalogs()
    {
        return $this->belongsToMany(ReservationStatusCatlog::class);
    }
}
