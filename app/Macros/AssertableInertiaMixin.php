<?php

namespace App\Macros;

use Closure;
use Inertia\Testing\AssertableInertia;
use InvalidArgumentException;
use PHPUnit\Framework\Assert as PHPUnit;

/**
 * @mixin AssertableInertia
 */
class AssertableInertiaMixin
{
    public function modal(): Closure
    {
        return function (string $value = null, $shouldExist = null) {
            PHPUnit::assertSame($value, $this->prop('modal.component'), 'Unexpected Inertia modal component.');

            if ($shouldExist || (is_null($shouldExist) && config('inertia.testing.ensure_pages_exist', true))) {
                try {
                    app('inertia.testing.view-finder')->find($value);
                } catch (InvalidArgumentException) {
                    PHPUnit::fail(sprintf('Inertia page component file [%s] does not exist.', $value));
                }
            }

            return $this;
        };
    }

    public function whereModal(): Closure
    {
        return fn (string $key, mixed $expected) => $this->where("modal.props.$key", $expected);
    }
}
