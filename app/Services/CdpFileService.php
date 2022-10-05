<?php

namespace App\Services;

use App\Models\CdpFiles;
use App\Services\Contracts\CdpFileServiceInterface;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CdpFileService implements CdpFileServiceInterface
{
    public static function store($file, $path , $hashDir)
    {
       $dir = Storage::put('public/', $file);
       $id = CdpFiles::create([
           'file_path' => $dir,
           'file_directory' => 'getImage/',
           'file_name' => basename('storage/app/'.$dir),
       ]);
       return $id;
    }

    public static function storeForCategories($file, $path , $hashDir , $filename)
    {
        $dir = Storage::put('public/'.$filename.'.png', $file);
        $id = CdpFiles::create([
            'file_path' => 'public/checks/'.$hashDir.'/'.$filename.'.png',
            'file_directory' => 'getImage/',
            'file_name' => $filename.'.png',
        ]);
        return $id;
    }

    public static function storeTest($file, $path , $hashDir)
    {
        $filename = sha1(uniqid());
        $dir = Storage::put('public/'.$filename.'.svg', $file);
        $id = CdpFiles::create([
            'file_path' => $dir,
            'file_directory' => 'storage/',
            'file_name' => $filename.'.svg',
        ]);
        return $filename;
    }

    public static function storeIfNoneFileType($file, $path , $hashDir , $filename)
    {

        $dir = Storage::put('public/'.$filename.'.png', base64_decode($file));
        $id = CdpFiles::create([
            'file_path' => 'public/checks/'.$hashDir.'/'.$filename.'.png',
            'file_directory' => 'getImage/',
            'file_name' => $filename.'.png',
        ]);
        return $id;
    }
}
