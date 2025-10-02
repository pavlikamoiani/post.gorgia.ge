<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function edit($folderId, $id)
    {
        $image = Image::with('user')->findOrFail($id);
        $folder = Folder::findOrFail($folderId);
        return view('images.edit', compact('image', 'folder'));
    }

    public function show($id)
    {
        $image = Image::findOrFail($id);
        $folder = $image->folder()->first();
        return view('images.show', compact('image', 'folder'));
    }

    public function create($folderId)
    {
        $folder = Folder::find($folderId);
        return view('images.upload', compact('folder'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request to ensure the 'images' field is an array and contains only valid image files
        $request->validate([
            'images' => 'required|array|min:2',  // Ensure there are at least 2 images
            'images.*' => '',  // Validate each image (ensure it is an image)
        ]);

        try {
            // Initialize an empty array to store the paths of the uploaded images
            $imagePaths = [];

            // Loop through the images array and store each image
            foreach ($request->file('images') as $image) {
                // Store each image in the 'public/images' folder and push the path to the array
                $imagePaths[] = $image->store('images', 'public');
            }

            // Prepare the data for batch insert
            $imageData = [];

            // Loop through the image paths in pairs (0,1), (2,3), (4,5), etc.
            for ($i = 0; $i < count($imagePaths); $i += 2) {
                // Ensure there is a pair (i.e., index 0 with 1, index 2 with 3, etc.)
                if (isset($imagePaths[$i + 1])) {
                    $imageData[] = [
                        'barcode' => $request->barcode,
                        'main_image' => $imagePaths[$i],  // First image in the pair as main_image
                        'secondary_image' => $imagePaths[$i + 1],  // Second image in the pair as secondary_image
                        'folder_id' => $request->folder_id,
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert the batch of image records into the database
            Image::insert($imageData);

        } catch (\Exception $e) {
            // Return error if any exception occurs during the file upload
            return back()->withErrors(['upload' => 'Image upload failed: ' . $e->getMessage()]);
        }

        // Redirect to the folder view with the updated folder ID
        return redirect()->route('folders.show', ['id' => $request->folder_id]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'main_image' => 'nullable',
            'secondary_image' => 'nullable',
            'barcode' => 'nullable',
        ]);

        $image = Image::findOrFail($id);

        // Update barcode
        $image->barcode = $request->barcode;

        // Update images if provided
        if ($request->hasFile('main_image')) {
            Storage::disk('public')->delete($image->main_image);
            $image->main_image = $request->file('main_image')->store('images', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            Storage::disk('public')->delete($image->secondary_image);
            $image->secondary_image = $request->file('secondary_image')->store('images', 'public');
        }

        // Optionally update the expiration date
        if ($request->expiration_date) {
            $image->expiration_date = $request->expiration_date;
        }

        $image->save();

        return redirect()->route('folders.show', ['id' => $image->folder->id]);
    }

    public function updateBarcode(Request $request, $id)
    {
        $image = Image::findOrFail($id);

        $image->barcode = $request->barcode;
        $image->save();

        return redirect()->route('images.show', ['id' => $id]);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        Storage::disk('public')->delete($image->main_image);
        Storage::disk('public')->delete($image->secondary_image);

        $image->delete();

        return redirect()->route('dashboard');
    }

}
