<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AssetStatus: String implements HasLabel
{
        // gooog, new, broken, null
    case Good = 'good';
    case New = 'new';
    case Broken = 'broken';
    case Null = 'null';

    public function getLabel(): ?string
    {
        // return $this->name;
        return match ($this) {
            self::Good => 'Good',
            self::New => 'New',
            self::Broken => 'Broken',
            self::Null => 'Null',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Good => 'success', // Hijau
            self::New => 'primary', // Biru
            self::Broken => 'danger', // Merah
            self::Null => 'gray', // Abu-abu
        };
    }
}
