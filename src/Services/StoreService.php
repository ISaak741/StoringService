<?php

namespace Storing\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    public function __construct(public $basePath) {}
    public function storeWithDefaultName(UploadedFile $file)
    {

        $name = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        return $this->storeWithCustomName($file, $name);
    }

    public function storeWithCustomName(UploadedFile $file, $name)
    {
        $name .= '.' . $file->getClientOriginalExtension();
        return Storage::putFileAs(
            $this->basePath,
            $file,
            $name
        );
    }

    public static function getUrls($path)
    {
        $files__ =  Storage::files($path, true);
        $files = [];

        foreach ($files__ as $file) {
            $files[] = json_decode(json_encode([
                'name' => basename($file),
                'url' => Storage::url($file)
            ]));
        }
        return $files;
    }
}
