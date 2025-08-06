<?php
namespace App\Helpers;

class Status
{
    public const BACKLOG = 'backlog';
    public const DEFECT = 'defect';
    public const TODO = 'todo';
    public const ON_GOING = 'on_going';
    public const COMPLETED = 'completed';

    public static function all(): array
    {
        return [
            self::BACKLOG,
            self::DEFECT,
            self::TODO,
            self::ON_GOING,
            self::COMPLETED,
        ];
    }

    public static function withColors(): array
    {
        return [
            self::BACKLOG => '#6B7280',  // Gray
            self::DEFECT => '#DC2626',  // Red
            self::TODO => '#3B82F6',  // Blue
            self::ON_GOING => '#F59E0B',  // Amber
            self::COMPLETED => '#10B981',  // Green
        ];
    }
}
