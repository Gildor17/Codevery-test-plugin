<?php

if (!defined("ABSPATH")) {exit;}

if (!class_exists('COTE_Logs')) {
    class COTE_Logs {
        private static $missingLogFile = false;
        private static $currentLogFileExists = false;

        public static $errors;

        public static function generateFilePaths() {
            try {
                $logsList = self::getLogsList();

                if (!empty($logsList)) {
                    foreach ($logsList as $k => $item) {
                        self::$currentLogFileExists = false;
                        try {
                            $filePath = COTE_PLUGIN_PATH.'/logs/'.$item;
                            if (file_exists($filePath)) {
                                self::$$k = $filePath;
                            } else {
                                if (class_exists('COTE_Utils')) {
                                    $currentLogFileExists = COTE_Utils::fileGenerator($filePath);
                                    if ($currentLogFileExists) {
                                        self::$$k = $filePath;
                                    } else {
                                        self::$missingLogFile = true;
                                    }
                                } else {
                                    self::$missingLogFile = true;
                                }
                            }
                        } catch (Exception $ex) {} catch (Error $er) {}
                    }
                    unset($k,$item);
                }
                return true;
            } catch (Exception $ex) {} catch (Error $er) {}
            return false;
        }

        private static function getLogsList() {
            // var name - file name
            $list = [
                'errors' => 'errors.log',
            ];

            return $list;
        }

        public static function saveLogs($logAttributeName, $text, $useDateBefore = true) {
            try {
                if (!empty(self::$$logAttributeName)) {
                    $message = PHP_EOL;
                    if (!empty($useDateBefore)) {
                        $message .= current_time('mysql');
                    }
                    $message .= ': '.$text.PHP_EOL;

                    error_log($message, 3, self::$$logAttributeName);
                }
            } catch (Exception $ex) {} catch (Error $er) {}
        }
    }
}