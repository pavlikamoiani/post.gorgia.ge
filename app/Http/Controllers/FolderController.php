<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = Folder::query();

        $nameFilter = $request->name;
        $dateFilter = $request->start_date;
        $branchFilter = $request->branch;

        if(!empty($request->name)) {
            $folders->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($nameFilter) . '%']);
        }

        if(!empty($request->start_date)) {
            $folders->whereDate('start_date', $dateFilter);
        }

        if(!empty($request->branch)) {
            $folders->whereRaw('LOWER(branch) LIKE ?', ['%' . strtolower($branchFilter) . '%']);
        }

        if(Auth::user()->role === 'viewer') {
            $folders->where('visible', 'public');
        }

        $folders = $folders->get();

        return view('dashboard', compact('folders'));
    }

    public function create()
    {
        return view('folders.create');
    }

    public function show($id)
    {
        $folder = Folder::with('user')->find($id);
        $images = $folder->images()->paginate(10); // Adjust the number of items per page as needed.

        if (request()->ajax()) {
            return view('folders.partials.images', compact('images'))->render();
        }

        return view('folders.show', compact('images', 'folder'));
    }


    public function edit(Folder $folder)
    {
        return view('folders.edit', compact('folder'));
    }

    public function store(Request $request)
    {
        Folder::create([
           'name' => $request->name,
           'start_date' => $request->start_date,
           'branch' => $request->branch,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('dashboard');
    }

    public function update(Request $request, Folder $folder)
    {
        $folder->update([
           'name' => $request->name,
           'start_date' => $request->start_date,
           'branch' => $request->branch
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        $folder = Folder::find($id);

        if($folder) {
            $folder->delete();
        }

        return redirect()->route('dashboard');
    }

    public function publishFolder($id)
    {
        $folder = Folder::find($id);

        if($folder) {
            $folder->visible = 'public';
            $folder->save();
        }

        return redirect()->route('dashboard');
    }
}
