<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Uploads $uploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Uploads $uploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Uploads $uploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Uploads $uploads)
    {
        //
    }

    public function upload(Request $request)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if (! $request->hasFile('aiz_file')) {
            Log::warning('file-uploader: no aiz_file in request', [
                'has_input' => $request->has('aiz_file'),
                'content_length' => $request->header('Content-Length'),
            ]);

            return response()->json([
                'error' => 'No file received',
                'hint' => 'Check PHP upload_max_filesize and post_max_size; ensure CSRF header is sent.',
            ], 422);
        }

        $file = $request->file('aiz_file');
        if (! $file->isValid()) {
            return response()->json([
                'error' => 'Invalid upload',
                'message' => $file->getErrorMessage(),
            ], 422);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        if (
            env('DEMO_MODE') == 'On' &&
            isset($type[$extension]) &&
            $type[$extension] == 'archive'
        ) {
            return response('{}', 200, ['Content-Type' => 'application/json']);
        }

        if (! isset($type[$extension])) {
            return response()->json([
                'error' => 'File type not allowed',
                'extension' => $extension,
            ], 422);
        }

        $upload = new Uploads;
        $upload->file_original_name = null;
        $arr = explode('.', $file->getClientOriginalName());
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($i == 0) {
                $upload->file_original_name .= $arr[$i];
            } else {
                $upload->file_original_name .= '.' . $arr[$i];
            }
        }

        $uploadDir = public_path('assets/uploads');
        if (! is_dir($uploadDir) && ! @mkdir($uploadDir, 0755, true) && ! is_dir($uploadDir)) {
            Log::error('file-uploader: cannot create upload directory', ['path' => $uploadDir]);

            return response()->json(['error' => 'Server cannot create upload folder'], 500);
        }

        try {
            $path = $file->store('assets/uploads', 'local');
            $size = $file->getSize();
            $upload->extension = $extension;
            $upload->file_name = $path;
            $upload->user_id = Auth::user()->id;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();
        } catch (\Throwable $e) {
            Log::error('file-uploader: save failed', ['exception' => $e->getMessage()]);

            return response()->json([
                'error' => 'Upload failed',
                'message' => config('app.debug') ? $e->getMessage() : 'Server error',
            ], 500);
        }

        return response('{}', 200, ['Content-Type' => 'application/json']);
    }

    public function show_uploader(Request $request)
    {
        return view('uploader.upload_file');
    }

    public function get_preview_files(Request $request)
    {
        $ids = explode(',', $request->ids);
        $files = Uploads::whereIn('id', $ids)->get();
        $new_file_array = [];
        foreach ($files as $file) {
            $file['file_name'] = ($file->file_name);
            // if ($file->external_link) {
            //     $file['file_name'] = $file->external_link;
            // }
            $new_file_array[] = $file;
        }
        // dd($new_file_array);
        return $new_file_array;
        // return $files;
    }

    public function get_uploaded_files(Request $request)
    {
        $uploads = Uploads::where('user_id', Auth::user()->id);
        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $uploads->paginate(60)->appends(request()->query());
    }

    public function upload_photo($file,$user_id)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );
        if (!empty($file)) {
            $name = explode("/", $file)[2];
            $upload = new Uploads();
            $upload->file_original_name = explode(".", $name)[0];
            $upload->extension = explode(".", $name)[1];
            $upload->file_name = $file;
            $upload->user_id = $user_id;
            $upload->type = 'image';
            $upload->is_farm_photo = 1;
            $upload->file_size = 1000;
            $upload->save();
            
            return $upload->id;
        }
    }

    public function upload_photo_supermarket($file,$user_id)
    {
        
        if (!empty($file)) {
            $name = explode("/", $file)[2];
            $upload = new Uploads();
            $upload->file_original_name = explode(".", $name)[0];
            $upload->extension = explode(".", $name)[1];
            $upload->file_name = $file;
            $upload->user_id = $user_id;
            $upload->type = 'image';
            $upload->is_farm_photo = 2;
            $upload->file_size = 1000;
            $upload->save();
            
            return $upload->id;
        }
    }
}
