<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUuids;

    protected $table =  "company";
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
        'name' => 'string'
    ];

    public function funds()
    {
        return $this->hasMany(FundCompany::class, "company_id");
    }

    public function hasRelatedFunds()
    {
        return $this->withCount('funds')->get();
    }
}
