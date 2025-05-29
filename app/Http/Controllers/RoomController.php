<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //list nya
    {
        //
        $rooms = Room::paginate(10); //eloquent ORM == menggantikan SQL select * statememt
        return view('rooms.index', compact('rooms')); //dia nak pass kan 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // untuk tunjukkan form, untuk isi kan data
    {
        //
        return view('rooms.create'); // rooms nama folder, index nama file
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate
        (
        [ //array

            'name' => 'required|string|max:225|unique:rooms,name', //rooms adalah nama yang uniq
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'capacity' => 'required|integer|between:40,150',
        ],

        //kalau nak dalam Bahasa Melayu (KENA CUSTOM)
        //[
            
           // 'name.required' => 'Sila isi nama bilik',
           // 'capacity.between' => 'Kapasiti mestilah di antara 40 hingga 150',

        //]
        );

        // Check if a photo was uploaded
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = 'room_' . time() . '.' . $image->getClientOriginalExtension(); //room_ mmg fix

            // satu function macam ECHO
            // dd([

            //     'image' => $image,
            //     'image_name' => $image_name

            // ]);

            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/rooms'); //nama folder baru dalam public 
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true); //0755 linux punya condition
            }

            // Resize the image to 300x300 using GD
            $resized_image = imagecreatetruecolor(300, 300); // untuk gambar besar tak muat so fix kan 300,300 pixel sahaja
            $source_image = ($image->getClientOriginalExtension() == 'png') ? imagecreatefrompng($image->getRealPath()) : imagecreatefromjpeg($image->getRealPath());
            list($width, $height) = getimagesize($image->getRealPath());
            imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 300, 300, $width, $height);

            // Save the image
            if ($image->getClientOriginalExtension() == 'png') {
                imagepng($resized_image, $directory . '/' . $image_name);
            } else {
                imagejpeg($resized_image, $directory . '/' . $image_name, 80); // 80 for JPEG quality
            }

            // Clean up resources
            imagedestroy($resized_image);
            imagedestroy($source_image);

            // Store the image path in the validated data
            $validatedData['photo'] = $image_name;
        }

        Room::create($validatedData); //eloquent ORM equivelent to insert into (SQL)

        return redirect()->back()->with('message', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room) //list
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room) //form
    {
        //
        return view('rooms.edit', compact('room')); // baru pass variables
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room) //logic
    {
        // mesti sama dengan store
        $validatedData = $request->validate
        ([

            'name' => 'required|string|max:225|unique:rooms,name,' . $room->id, //rooms adalah nama yang uniq, untuk kekalkan nama bilik (tak perlu di ubah) // "." maksudnya gabung dengan room
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'capacity' => 'required|integer|between:40,150',

        ]);

        if ($request->hasFile('photo')) 
        {
            $image = $request->file('photo');
            $image_name = 'room_' . time() . '.' . $image->getClientOriginalExtension(); //room_ mmg fix

            // satu function macam ECHO
            // dd([

            //     'image' => $image,
            //     'image_name' => $image_name

            // ]);

            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/rooms'); //nama folder baru dalam public 
            if (!file_exists($directory)) 
            {
                mkdir($directory, 0755, true); //0755 linux punya condition
            }

            // Resize the image to 300x300 using GD
            $resized_image = imagecreatetruecolor(300, 300); // untuk gambar besar tak muat so fix kan 300,300 pixel sahaja
            $source_image = ($image->getClientOriginalExtension() == 'png') ? imagecreatefrompng($image->getRealPath()) : imagecreatefromjpeg($image->getRealPath());
            list($width, $height) = getimagesize($image->getRealPath());
            imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 300, 300, $width, $height);

            // Save the image
            if ($image->getClientOriginalExtension() == 'png') 
            {
                imagepng($resized_image, $directory . '/' . $image_name);
            } else { 
                imagejpeg($resized_image, $directory . '/' . $image_name, 80); // 80 for JPEG quality
            }

            // Clean up resources
            imagedestroy($resized_image);
            imagedestroy($source_image);

            // Store the image path in the validated data
            $validatedData['photo'] = $image_name;
        }
        else // kalau nak upload gambar 
        {
            $validatedData['photo'] = $room->photo;

        }

        $room->update($validatedData); // Equivalent to sql update name_table set

        return redirect()->back()->with('message', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
        $room->delete(); // Equivalent to delete from table_name where id="";
        return redirect()->back()->with('message', 'Room deleted successfully'); // back (page sebelumnya, bile tekan delete dia akan pergi ke page yang asal)
    }
}
