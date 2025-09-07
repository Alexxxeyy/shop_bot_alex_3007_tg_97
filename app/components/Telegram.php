<?php
namespace app\components;

class Telegram
{
    public static function getInputData()
    {
        $input = file_get_contents('php://input');
        if ($input){
            return json_decode($input, true);
        }
return [];
    }
}