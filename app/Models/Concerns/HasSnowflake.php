<?php

namespace App\Models\Concerns;

use App\Support\Facades\Snowflake;
use Illuminate\Database\Eloquent\Model;

trait HasSnowflake
{
    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function bootHasSnowflake(): void
    {
        static::created(static fn (Model $model) => $model->forceFill([
            'sid' => $model->sid ?? Snowflake::encode($model->id),
        ])->save());
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'sid';
    }
}
