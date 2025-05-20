<?php

namespace App;

enum TransactionTypeEnum
{
    case DEPOSIT;
    case TRANSFER;

    public function getLabel(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Depósito',
            self::TRANSFER => 'Transferência',
        };
    }
}
