<?php

namespace App\Helpers;

class Status
{
    public const BACKLOG = 'backlog';
    public const DEFECT = 'defect';
    public const TODO = 'todo';
    public const ON_GOING = 'on_going';
    public const COMPLETED = 'completed';

    public static function all()
    {
        return [
            self::BACKLOG,
            self::DEFECT,
            self::TODO,
            self::ON_GOING,
            self::COMPLETED,
        ];
    }
}
