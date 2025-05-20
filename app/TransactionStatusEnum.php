<?php

namespace App;

enum TransactionStatusEnum
{
    case PENDING;
    case COMPLETED;
    case FAILED;
    case REFUNDED;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::COMPLETED => 'Concluído',
            self::FAILED => 'Falhou',
            self::REFUNDED => 'Reembolsado',
        };
    }
}
