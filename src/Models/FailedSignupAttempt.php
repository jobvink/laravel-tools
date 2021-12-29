<?php

namespace jobvink\lumc\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedSignupAttempt extends Model
{
    use HasFactory;
    protected $fillable = ['reason'];

    public static function createDuplicateFailedAttempt()
    {
        return self::create(['reason' => 'duplicate']);
    }

    public static function createScreeningFailed()
    {
        return self::create(['reason' => 'screening']);
    }

    public static function createRecaptiaFailed()
    {
        return self::create(['reason' => 'screening']);
    }
}
