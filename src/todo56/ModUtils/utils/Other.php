<?php
namespace todo56\ModUtils\utils;

class Other {
    static function replaceVars(string $message, array $items): string {
        $msg = $message;
        $keys = array_keys($items);
        $values = array_values($items);
        for($i = 0; $i < count($items); $i++){
            $msg = str_replace($keys[$i], $values[$i], $msg);
        }
        return $msg;
    }
}