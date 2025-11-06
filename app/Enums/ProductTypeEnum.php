<?php

namespace App\Enums;

enum ProductTypeEnum: string
{
    case SAVORY = 'savory';
    case DRINK = 'drink';
    case SNACK = 'snack';
    case DESSERT = 'dessert';

    public function label (): string {
        return match ($this) {
            self::SAVORY => 'Salgado',
            self::DRINK => 'Bebida',
            self::SNACK => 'Lanche',
            self::DESSERT => 'Sobremesa'
        };
    }

    public static function values (): array {
        return array_column(self::cases(), 'value');
    }
}
