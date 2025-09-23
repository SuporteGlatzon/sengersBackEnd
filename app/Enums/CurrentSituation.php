<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CurrentSituation: string implements HasColor, HasIcon, HasLabel
{
    case Interrupted = 'interrupted';

    case InProgress = 'in_progress';

    case Done = 'done';

    public function getLabel(): string
    {
        return match ($this) {
            self::Interrupted => 'Interrompido',
            self::InProgress => 'Em andamento',
            self::Done => 'Concluído',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Interrupted => Color::Red,
            self::InProgress => Color::Amber,
            self::Done => Color::Lime,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Interrupted => 'heroicon-m-stop-circle',
            self::InProgress => 'heroicon-m-arrow-path',
            self::Done => 'heroicon-m-check-badge',
        };
    }
}
