<?php

class AdminService {
    
    public static function shortText($text, $length = 200){
        if(strlen($text) > 200){
            return mb_substr($text, 0, $length, 'utf8') . '...';
        } else {
            return $text;
        }
        
    }
}
