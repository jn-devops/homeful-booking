<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilePondController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $path = $file->store('uploads', 'public');
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'File not uploaded'], 400);
    }

    public function revert(Request $request)
    {
        $filename = $request->getContent();
        Storage::disk('public')->delete($filename);
        return response()->json(['message' => 'File deleted']);
    }
}
