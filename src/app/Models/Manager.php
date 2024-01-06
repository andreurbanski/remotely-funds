<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasUuids;

    protected $table =  "manager";
    protected $keyType = 'string';
    public $incrementing = false;

    protected $with = [
        "funds"
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    public $filters = [
        'name' => 'string',
    ];

    public function funds()
    {
        return $this->hasMany(Fund::class, "manager_id");
    }
}
