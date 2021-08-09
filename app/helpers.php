<?php

declare(strict_types=1);

if (!function_exists('putSource')) {
  /**
   * @return string
   */
  // 関数：動作環境に応じたpublicフォルダに内ファイルのurlを取得する
  function putSource($file): string
  {
    if (app('env') == 'local') {
      $url = asset($file);
    } else {
      $url = secure_asset($file);
    }
    return $url;
  }
}
