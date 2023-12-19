<?php

namespace Helpers;

use Exception;

class ValidationHelper
{
    public static function title(string $title) : array {

        if (!mb_check_encoding($title, 'UTF-8') && !(bool)preg_match('//u', $title)) {
            return ['success' => false, 'message' => '無効なテキスト: エンコーディングが無効またはUnicode文字以外が含まれています。'];
        }

        $titleSize = mb_strlen($title);
        $textMaxLength = 300; 

        if ($titleSize > $textMaxLength) {
            return ['success' => false, 'message' => '無効なテキスト: タイトルの最大文字数は300文字です。'];
        }

        return ['success' => true];

    }

    public static function body(string $content, string $type): array
    {
        if ((bool)preg_match('/^\s*$/', $content)) {
            return ['success' => false, 'message' => '無効なテキスト: コンテンツが空白の投稿はできません。'];
        }

        if (!mb_check_encoding($content, 'UTF-8') && !(bool)preg_match('//u', $content)) {
            return ['success' => false, 'message' => '無効なテキスト: エンコーディングが無効またはUnicode文字以外が含まれています。'];
        }

        $contentSize = mb_strlen($content);
        // main postの場合40000文字、commentの場合10000文字に制限する。
        if($type == 'main') $textMaxLength = 40000;
        elseif($type == 'comment') $textMaxLength = 10000;
        else throw new Exception('無効の引数typeが入力されました。');

        if ($contentSize > $textMaxLength) {
            if($type == 'main') return  ['success' => false, 'message' => '無効なテキスト: ポストできる最大文字数は40000文字です。'];
            else return ['success' => false, 'message' => '無効なテキスト: コメントの最大文字数は10000文字です。'];
        }

        return ['success' => true];
    }

    public static function image(string $mime, int $byteSize) : array {

        $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/gif'];

        if(!in_array($mime, $allowedMimeTypes)){
            return ['success' => false, 'message' => 'png,jpg,gif以外の拡張子には対応していません。'];
        }

        $isSmallerThan5MB = $byteSize < (5 * 1024 * 1024); // 5MBをバイトに変換

        if(!$isSmallerThan5MB){
            return ['success' => false, 'message' => '5MBより大きい画像はアップロードできません。'];
        }
    

        return ['success' => true];
    }

}
