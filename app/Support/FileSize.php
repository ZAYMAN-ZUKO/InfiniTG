<?php

namespace App\Support;

class FileSize
{
    public static function human(int $bytes, int $precision = 1): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        $units = ['KB', 'MB', 'GB', 'TB'];

        $value = $bytes / 1024;
        $unit = 'KB';

        foreach ($units as $candidate) {
            if ($value < 1024) {
                $unit = $candidate;
                break;
            }
            $value /= 1024;
        }

        return number_format($value, $precision) . ' ' . $unit;
    }
}