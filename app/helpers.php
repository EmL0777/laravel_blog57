<?php

/**
 * 返回可讀性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}


/**
 * 判斷文件的 MIME 類型是否為圖片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}
