<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadsManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    protected $manage;

    public function __construct(UploadsManager $manage)
    {
        $this->manager = $manage;
    }

    /**
     * Show page of files / subfolders
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index', $data);
    }

    /**
     * 建立新目錄
     * @param UploadNewFolderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder') . '/' . $new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '目錄「' . $new_folder . '」建立成功.');
        }

        $error = $result ?: "建立目錄出錯.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 刪除目錄
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder') . '/' . $del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '目錄「' . $del_folder . '」已删除');
        }

        $error = $result ?: "目錄刪除出錯.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 上傳檔案
     * @param UploadFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            return redirect()
                ->back()
                ->with("success", '檔案「' . $fileName . '」上傳成功.');
        }

        $error = $result ?: "檔案上傳出錯.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 刪除檔案
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder') . '/' . $del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '檔案「' . $del_file . '」已删除.');
        }

        $error = $result ?: "檔案刪除出錯.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }
}
