<?php
namespace App\Http\Controllers;
use App\Models\Photo;
use App\Models\Flexible;
use Illuminate\Http\Request;
class FlexibleController extends Controller
{
    /* Display a listing of the resource. */
    public function index() {
        $flexibles = Flexible::orderBy('created_at', 'desc')->paginate(3); 
        return view('flexibles.index', ['flexibles' => $flexibles]);
    }
    /* Show the form for creating a new resource.*/
    public function create()
    {
        return view('flexibles.create');
    }
    /* Store a newly created resource in storage.*/
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'last_check_date' => 'required|date',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $flexible = Flexible::create([
            'title' => $request->title,
            'last_check_date' => $request->last_check_date,
        ]);
        if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $index => $file)
                {
                    $name = time().'_'.$index.'.'.$file->extension();
                    $file->move(public_path().'/images/', $name);  
                    $flexible->photos()->create([
                        'path' => '/images/'.$name
                    ]);
                }
            }
      // Generate QR code
      $qrCode = \QrCode::size(500)
      ->format('png')
      ->generate(route('flexibles.show', $flexible), public_path('qrcodes/'.$flexible->id.'.png'));
        return redirect()->route('flexibles.index');
    }
    // Display the specified resource
    public function show(Flexible $flexible)
    {
        return view('flexibles.show', compact('flexible'));
    }
    // Show the form for editing the specified resource.
    public function edit(Flexible $flexible)
    {
        return view('flexibles.edit', compact('flexible'));
    }
   //Update
    public function update(Request $request, Flexible $flexible)
    {
        $request->validate([
            'title' => 'required',
            'last_check_date' => 'required|date',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $flexible->title = $request->title;
        $flexible->last_check_date = $request->last_check_date;
        $flexible->save();
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $name = time() . '_' . $index . '.' . $file->extension();
                $file->move(public_path('/images'), $name);
                $flexible->photos()->create([
                    'path' => '/images/' . $name
                ]);
            }
        }
        return redirect()->route('flexibles.index');
    }  
    public function updateFields(Request $request, Flexible $flexible)
    {
        $request->validate([
            'date_verification' => 'required|date',
            'status' => 'required',
            'etat' => 'required',
            'controlleur' => 'required',
        ]);

        $flexible->update([
            'date_verification' => $request->date_verification,
            'status' => $request->status,
            'etat' => $request->etat,
            'controlleur' => $request->controlleur,
        ]);

        return back();
    }


    //Remove the specified resource from storage.
    public function destroy(Flexible $flexible)
    {
        // Delete the photos
        foreach ($flexible->photos as $photo) {
            // delete the photo file
            if (file_exists(public_path() . $photo->path)) {unlink(public_path() . $photo->path);}}
        // Delete the QR code
        $qrCodePath = public_path('qrcodes/'.$flexible->id.'.png');
        if (file_exists($qrCodePath)) {unlink($qrCodePath);}
        // Delete the flexible
        $flexible->delete();
        return redirect()->route('flexibles.index');
    }
    public function deletePhoto(Photo $photo) {
        // Delete the photo file
        if (file_exists(public_path() . $photo->path)) {unlink(public_path() . $photo->path);}
        // Delete the photo from the database
        $photo->delete();
    }
}