<?php

use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_Utils
{

    /**
     * @param $input
     * @param $preffix_log
     */
    public static function writeLog($input, $preffix_log = "o8jobs Log")
    {
        try {
//            if (self::getSaveLog()) {
                if (is_object($input)) {
                    $masquerade_input = (array)$input;
                } else {
                    $masquerade_input = $input;
                }
                if (is_array($masquerade_input)) {
                    $fields_to_hide = ['Signature', 'qfKey'];
                    foreach ($fields_to_hide as $field_to_hide) {
                        unset($masquerade_input[$field_to_hide]);
                    }
                    Civi::log()->debug($preffix_log . "\n" . print_r($masquerade_input, TRUE));
                    return;
                }

                Civi::log()->debug($preffix_log . "\n" . $masquerade_input);
                return;
//            }
        } catch (\Exception $exception) {
            $error_message = $exception->getMessage();
            $error_title = 'o8jobs Configuration Required';
            self::showErrorMessage($error_message, $error_title);
        }
    }
}





