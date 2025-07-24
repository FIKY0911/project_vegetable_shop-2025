<?php

namespace App\Enums;

enum ProductCategory: string
{
    case DAUN = 'daun';
    case BATANG = 'batang';
    case AKAR = 'akar';
    case UMBI = 'umbi';
    case BUAH = 'buah';
    case BIJI = 'biji';

    public function label(): string
    {
        return match ($this) {
            self:: DAUN => 'Daun',
            self:: BATANG => 'Batang',
            self:: AKAR => 'Akar',
            self:: UMBI => 'Umbi',
            self:: BUAH => 'Buah',
            self:: BIJI => 'Biji',
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
