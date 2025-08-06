<?php

namespace App\Helpers;

class StoryPoint
{
    public const SMALL = 'SMALL';
    public const MEDIUM = 'MEDIUM';
    public const LARGE = 'LARGE';

    public static function all(): array
    {
        return [
            self::SMALL,
            self::MEDIUM,
            self::LARGE,
        ];
    }

    public static function withDetails(): array
    {
        return [
            self::SMALL => [
                'name' => 'SMALL',
                'value' => self::SMALL,
                'hours' => 2,
            ],
            self::MEDIUM => [
                'name' => 'MEDIUM',
                'value' => self::MEDIUM,
                'hours' => 4,
            ],
            self::LARGE => [
                'name' => 'LARGE',
                'value' => self::LARGE,
                'hours' => 8,
            ],
        ];
    }
}
