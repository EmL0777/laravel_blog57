<?php

namespace App\Http\Controllers\Admin;

use App\Services\UploadsManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    protected $manage;

    public function __construct(UploadsManager $manage)
    {
        $this->manage = $manage;
    }

    /**
     * Show page of files / subfolders
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manage->folderInfo($folder);

        return view('admin.upload.index', $data);
    }
}
