<?php

class ConvertionService
{

    public function __construct()
    {
    }

    public function timeToString($time, $format = '%02dh %02dmin'): string
    {
        if ($time < 1) {
            return "";
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public function parseRepeater(array $array, string $field_name): array|int
    {
        $return_array = [];
        for ($i = 1; $i <= $array[$field_name]; $i++) {
            $return_block = [];
            foreach ($array as $key => $block_value) {
                if (!str_starts_with($key, "_") && str_contains($key, $field_name . '_' . $i . '_')) {
                    $return_block[str_replace($field_name . '_' . $i . '_', "", $key)] = $block_value;
                }
            }
            $return_array[] = $return_block;
        }
        return $return_array;
    }

    public function getCrew(array $array, string $job = "director")
    {
        $result = [];

        foreach ($array as $item) {
            if($item['job'] == $job) {
                $result[] = $item;
            }
        }

        return$result;
    }
}

/*
 *  private function parseRepeater(array $array, string $field_name): array|int
    {
        $return_array = [];
        $isBreak = false;

        if (!is_array($array[$field_name])) {
            for ($i = 0; $i < $array[$field_name]; $i++) {
                $return_block = [];
                foreach ($array as $key => $block_value) {
                    if (str_contains($key, $field_name . '_' . $i . '_')) {
                        $return_block[str_replace($field_name . '_' . $i . '_', "", $key)] = $block_value;
                    }
                }
                $return_array[] = $return_block;
            }
        } else $isBreak = true;
        return $isBreak ? $array[$field_name] : $return_array;
    }
 */