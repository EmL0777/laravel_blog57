@extends('admin.layout')

@section('content')
    <div class="container">

        {{-- 頂部工具欄 --}}
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3 class="pull-left">上傳 </h3>
                <div class="pull-left">
                    <ul class="breadcrumb">
                        @foreach ($breadcrumbs as $path => $disp)
                            <li><a href="/admin/upload?folder={{ $path }}">{{ $disp }}</a></li>
                        @endforeach
                        <li class="active">{{ $folderName }}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
                    <i class="fa fa-plus-circle"></i> 新增目錄
                </button>
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                    <i class="fa fa-upload"></i> 上傳
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="uploads-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>名稱</th>
                        <th>類型</th>
                        <th>日期</th>
                        <th>尺寸</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    {{-- 子目录 --}}
                    @foreach ($subfolders as $path => $name)
                        <tr>
                            <td>
                                <a href="/admin/upload?folder={{ $path }}">
                                    <i class="fa fa-folder fa-lg fa-fw"></i>
                                    {{ $name }}
                                </a>
                            </td>
                            <td>目錄</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" onclick="delete_folder('{{ $name }}')">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                    刪除
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 所有文件 --}}
                    @foreach ($files as $file)
                        <tr>
                            <td>
                                <a href="{{ $file['webPath'] }}">
                                    @if (is_image($file['mimeType']))
                                        <i class="fa fa-image fa-lg fa-fw"></i>
                                    @else
                                        <i class="fa fa-file fa-lg fa-fw"></i>
                                    @endif
                                    {{ $file['name'] }}
                                </a>
                            </td>
                            <td>{{ $file['mimeType'] ? : 'Unknown' }}</td>
                            <td>{{ $file['modified']->format('j-M-y g:ia') }}</td>
                            <td>{{ human_filesize($file['size']) }}</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{ $file['name'] }}')">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                    删除
                                </button>
                                @if (is_image($file['mimeType']))
                                    <button type="button" class="btn btn-xs btn-success" onclick="preview_image('{{ $file['webPath'] }}')">
                                        <i class="fa fa-eye fa-lg"></i>
                                        預覽
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @include('admin.upload._modals')

@stop

@section('scripts')
    <script>

        // 確認文件刪除
        function delete_file(name) {
            $("#delete-file-name1").html(name);
            $("#delete-file-name2").val(name);
            $("#modal-file-delete").modal("show");
        }

        // 確認目錄刪除
        function delete_folder(name) {
            $("#delete-folder-name1").html(name);
            $("#delete-folder-name2").val(name);
            $("#modal-folder-delete").modal("show");
        }

        // 預覽圖片
        function preview_image(path) {
            $("#preview-image").attr("src", path);
            $("#modal-image-view").modal("show");
        }

        // 初始化數據
        $(function() {
            $("#uploads-table").DataTable();
        });
    </script>
@stop
