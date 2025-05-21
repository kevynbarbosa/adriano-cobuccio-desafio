<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';

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
