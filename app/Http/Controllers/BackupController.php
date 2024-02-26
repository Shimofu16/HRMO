<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $path = 'HRMO';
        $files = collect(Storage::disk('backup')->allFiles($path));
        $backups = $files->map(function ($file) use ($path) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::disk('backup')->size($file) >= 1048576 ? round(Storage::disk('backup')->size($file) / 1024 / 1024, 2) . ' MB' : round(Storage::disk('backup')->size($file) / 1024, 2) . ' KB',
                'disk' => 'backup',
                'url' => Storage::disk('backup')->url($file),
                'created_at' => Storage::disk('backup')->lastModified($file),
            ];
        })->sortByDesc('created_at');

        return view('settings.backups.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $file_name = 'HRMO-DB-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip';
        $command = 'backup:run';
        $arguments = ['--only-db' => true, '--filename' => $file_name];

        //check if there is a backup already created
        if (Storage::disk('backup')->exists('HRMO/' . $file_name)) {
            return redirect()->back()->with('error', 'Backup already created');
        }

        Artisan::call($command, $arguments);

        return redirect()->back()->with('success', 'Backup created successfully');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $file_name)
    {
    }

    /**
     * Download File
     */
    public function download(string $file_name)
    {
        return Storage::disk('backup')->download('HRMO/' . $file_name);
    }
}
