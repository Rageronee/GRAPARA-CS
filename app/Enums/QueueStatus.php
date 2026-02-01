<?php

namespace App\Enums;

enum QueueStatus: string
{
    case WAITING = 'waiting';
    case CALLING = 'calling';
    case SERVING = 'serving';
    case COMPLETED = 'completed';
    case SKIPPED = 'skipped';

    public function label(): string
    {
        return match ($this) {
            self::WAITING => 'Menunggu',
            self::CALLING => 'Dipanggil',
            self::SERVING => 'Sedang Dilayani',
            self::COMPLETED => 'Selesai',
            self::SKIPPED => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::WAITING => 'slate',
            self::CALLING => 'yellow',
            self::SERVING => 'blue',
            self::COMPLETED => 'green',
            self::SKIPPED => 'red',
        };
    }
}
