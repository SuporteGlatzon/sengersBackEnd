<?php

namespace App\Enums;

use App\Models\Opportunity;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OpportunitySituation: string implements HasColor, HasIcon, HasLabel
{
    case SITUATION_PENDING = Opportunity::SITUATION_PENDING;

    case SITUATION_NO_APPROVED = Opportunity::SITUATION_NO_APPROVED;

    case SITUATION_APPROVED = Opportunity::SITUATION_APPROVED;

    case SITUATION_EXPIRED = Opportunity::SITUATION_EXPIRED;

    public function getLabel(): string
    {
        return match ($this) {
            self::SITUATION_PENDING => __('Pending'),
            self::SITUATION_NO_APPROVED => __('No approved'),
            self::SITUATION_APPROVED => __('Approved'),
            self::SITUATION_EXPIRED => __('Expired'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::SITUATION_PENDING => Color::Stone,
            self::SITUATION_NO_APPROVED => Color::Red,
            self::SITUATION_APPROVED => Color::Green,
            self::SITUATION_EXPIRED => Color::Yellow,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SITUATION_PENDING => 'heroicon-m-arrow-path',
            self::SITUATION_NO_APPROVED => 'heroicon-m-x-circle',
            self::SITUATION_APPROVED => 'heroicon-m-check-circle',
            self::SITUATION_EXPIRED => 'heroicon-m-clock'
        };
    }
}
