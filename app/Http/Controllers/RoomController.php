<?php

namespace App\Http\Controllers;


use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Traits\UploadImageTrait;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{   
    use UploadImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rooms = Room::with('roomType')
                ->whereHas('roomType', function ($query) use ($request) {
                    if ($request->has('name')) {
                        $query->where('name', 'like', '%' . $request->name . '%');
                    }
                })
                ->orderBy('floorNumber', 'asc')
                ->paginate(10);
            return view('Admin.pages.dashboard.rooms.index', compact('rooms'));
        } catch (\Exception $e) {
            Log::error('Error in RoomController@index: ' . $e->getMessage());
            return redirect()->route('rooms.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('Admin.pages.dashboard.rooms.create' , compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {   
        $validatedData=$request->validated();
        $room=Room::create([
            "room_type_id" => $request->room_type,
            "code" => $validatedData['code'],
            "floorNumber" => $validatedData['floorNumber'],
            "description" => $validatedData['description'],
            "img" => $this->verifyAndUpload($validatedData['img'],'rooms'),
            "status" => $validatedData['status'],
            "price" => $validatedData['price'],
        ]);

        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('Admin.pages.dashboard.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {   
        $roomTypes = RoomType::all();
        return view('Admin.pages.dashboard.rooms.edit', compact('room','roomTypes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {   
        try {
            $request->validated();
            $room->code =$request->code ?? $room->code;
            $room->room_type_id =$request->room_type_id ?? $room->room_type_id;
            $room->floorNumber = $request->floorNumber ?? $room->floorNumber;
            $room->price = $request->price ?? $room->price;
            $room->status = $request->status ?? $room->status;
            $room->description = $request->description ?? $room->description;

            if ($request->hasFile('img')) {
                $path =$this->verifyAndUpload($request->file('img'),'rooms');
                if ($path) {
                    $this->deleteImage($room->img);
                    $room->img = $path;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload image.');
                }
            }
            $room->save();
            return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');

        } catch (\Exception $e) {
            Log::error('Error in RoomController@update: ' . $e->getMessage());
            return redirect()->route('rooms.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $this->deleteImage($room->img);
            $room->delete();
            return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in RoomController@destroy: ' . $e->getMessage());
            return redirect()->route('Admin.pages.dashboard.rooms.index')->with('error',$e->getMessage());
        }
    }
}
