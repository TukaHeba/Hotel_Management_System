<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use App\Models\ReservationStatusEvent;
use App\Models\ReservationStatusCatlog;

class ReservationEventController extends Controller
{
    use ApiResponserTrait;

    public function reservationEvents(Reservation $reservation)
    {
        #first way to solve this 
        // try {
        //     $reservationStatusOverTime = [];
        //     $reservationEvents = ReservationStatusEvent::where('reservation_id', $reservation->id)->get();

        //     foreach ($reservationEvents as $reservationEvent) {
        //         $reservationCurrentStatus=ReservationStatusCatlog::where(
        //             'id',$reservationEvent->reservation_status_catlog_id)
        //             ->pluck('name')
        //             ->first();
        //         $reservationCurrentEventDate = $reservationEvent
        //         ->created_at
        //         ->format('d-m-Y H:i:s');
        //         $reservationStatusOverTime[] = [
        //             'currentStatus' => $reservationCurrentStatus,
        //             'currentEventDate' => $reservationCurrentEventDate,
        //         ];
        //     }
        try {
            // another way to apply the same logic is to Load reservation events with the Relation 
            $reservationEvents = ReservationStatusEvent::with('statusCatalog')
                                ->where('reservation_id', $reservation->id)
                                ->get();
    
            $reservationStatusOverTime = [];
    
            foreach ($reservationEvents as $reservationEvent) {
                $reservationCurrentStatus = $reservationEvent->statusCatalog->name;
                $reservationCurrentEventDate = $reservationEvent->created_at->format('d-m-Y H:i:s');
    
                $reservationStatusOverTime[] = [
                    'currentStatus' => $reservationCurrentStatus,
                    'currentEventDate' => $reservationCurrentEventDate,
                ];
            } 
            return $this->successResponse($reservationStatusOverTime, 'Reservation Events Returned Successfully');
        } catch (Throwable $th) {
            return $this->errorResponse('Server error probably.', [$th->getMessage()], 500);
        }
    }

}