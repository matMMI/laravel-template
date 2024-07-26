<?php
namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;
class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        $path = $request->file('image')->store('images', 'public');
        $image = new Image;
        $image->path = $path;
        $image->save();
        return back()->with('imagePath', $path);
    }
  
}