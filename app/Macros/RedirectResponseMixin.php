<?php

namespace App\Macros;

use Closure;
use Illuminate\Http\RedirectResponse;

/**
 * @mixin RedirectResponse
 */
class RedirectResponseMixin
{
    /**
     * @return Closure
     */
    public function withSuccess(): Closure
    {
        return fn (string $message): static => $this->with('success', $message);
    }

    /**
     * @return Closure
     */
    public function withDanger(): Closure
    {
        return fn (string $message): static => $this->with('danger', $message);
    }

    /**
     * @return Closure
     */
    public function withError(): Closure
    {
        return fn (string $message): static => $this->with('danger', $message);
    }

    /**
     * @return Closure
     */
    public function withWarning(): Closure
    {
        return fn (string $message): static => $this->with('warning', $message);
    }
}
