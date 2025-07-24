<?php

namespace App\Enums;

enum PaymentTransaction: string
{
    case DANA = 'dana';
    case GOPAY = 'gopay';
    case CASH = 'cash';
    case QRIS = 'qris';

    public function label(): string
    {
        return match ($this) {
            self::DANA => 'Dana',
            self::GOPAY => 'Gopay',
            self::CASH => 'Cash',
            self::QRIS => 'Qris',
        };
    }

    // public static function labels(): array
    // {
    //     return array_map(
    //         fn($case) => $case->label(),
    //         self::cases()
    //     );
    // }
    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
