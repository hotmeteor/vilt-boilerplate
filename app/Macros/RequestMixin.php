<?php

namespace App\Macros;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

/**
 * @mixin Request
 */
class RequestMixin
{
    /**
     * @return Closure
     */
    public function search(): Closure
    {
        return fn (string $key = 'search'): mixed => $this->input($key, '') ?? '';
    }

    /**
     * @return Closure
     */
    public function team(): Closure
    {
        return fn (): ?Team => $this->user()->currentTeam;
    }
}
