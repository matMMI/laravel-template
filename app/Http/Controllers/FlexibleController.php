<?php
namespace App\Http\Controllers;
use App\Models\Photo;
use App\Models\Flexible;
use Illuminate\Http\Request;
class FlexibleController extends Controller
{

    public function index() {
        $flexibles = Flexible::orderBy('created_at', 'desc')->paginate(3); 
        return view('flexibles.index', ['flexibles' => $flexibles]);
    }

    public function create()
    {
        return view('flexibles.create');
    }

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

            $qrCode = \QrCode::format('png')->size(500)->encoding('UTF-8')
            ->generate(route('flexibles.show', $flexible), public_path('qrcodes/'.$flexible->id.'.png'));
        return redirect()->route('flexibles.index');
    }

    public function show(Flexible $flexible)
    {
        return view('flexibles.show', compact('flexible'));
    }

    public function edit(Flexible $flexible)
    {
        return view('flexibles.edit', compact('flexible'));
    }

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



    public function destroy(Flexible $flexible)
    {

        foreach ($flexible->photos as $photo) {

            if (file_exists(public_path() . $photo->path)) {unlink(public_path() . $photo->path);}}

        $qrCodePath = public_path('qrcodes/'.$flexible->id.'.png');
        if (file_exists($qrCodePath)) {unlink($qrCodePath);}

        $flexible->delete();
        return redirect()->route('flexibles.index');
    }
    public function deletePhoto(Photo $photo) {

        if (file_exists(public_path() . $photo->path)) {unlink(public_path() . $photo->path);}

        $photo->delete();
    }
}