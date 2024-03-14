<?php


namespace app\models;

class Helper
{
    public static function returnErrorsString(array $errors_array): string
    {
        $errors = '';
        foreach ($errors_array as $error) {
            foreach ($error as $e) {
                $errors .= $e . '<br/>';
            }
        }
        return $errors;
    }
}