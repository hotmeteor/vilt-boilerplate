<?php

namespace App\Macros;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class BlueprintMixin
{
    public function sid(): Closure
    {
        return fn (): ColumnDefinition => /** @var Blueprint $this */ $this->unsignedBigInteger('sid')->nullable()->index();
    }
}
