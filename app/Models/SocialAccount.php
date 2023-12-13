<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSocialAccount
 */
class SocialAccount extends BaseModel
{
    protected $table = 'social_accounts';

    protected $casts = [
        'token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'expires_in' => 'integer',
        'meta' => AsArrayObject::class,
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
