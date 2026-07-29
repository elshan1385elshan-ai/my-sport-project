<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $files = collect(Storage::disk('public')->files('icons'))
            ->filter(fn ($path) => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico']))
            ->map(fn ($path) => [
                'name' => basename($path),
                'path' => $path,
                'url' => Storage::url($path),
                'size' => Storage::disk('public')->size($path),
                'last_modified' => Storage::disk('public')->lastModified($path),
            ])
            ->values();

        return view('admin.media.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp,ico|max:2048',
        ]);

        $file = $request->file('file');
        $name = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('icons', $name, 'public');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::url($path),
                'name' => $name,
            ]);
        }

        return redirect()->route('media.index')->with('success', 'فایل با موفقیت آپلود شد');
    }

    public function destroy($file)
    {
        $path = 'icons/' . basename($file);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('media.index')->with('success', 'فایل با موفقیت حذف شد');
    }
}
