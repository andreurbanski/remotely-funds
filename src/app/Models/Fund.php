<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fund extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table =  "funds";

    protected $with = [
        'companies'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start_year',
        'manager_id',
        'aliases'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aliases' => 'array',
    ];

    public $filters = [
        'name' => 'string',
        'year' => 'integer',
        'manager_id' => 'uuid'
    ];

    public function companies()
    {
        return $this->hasMany(FundCompany::class, "fund_id");
    }

    public function checkDuplicates(Company $company)
    {
        $fund = $this->whereHas("companies", function (Builder $query) use ($company) {
            $query->where("company_id", $company->id);
        })->get();

        return $fund;
    }

    public static function checkDuplicatedFunds(Fund $fund = null)
    {

        $query =  "";
        if (!is_null($fund)) {
            $query = " AND f1.id = '{$fund->id}'";
        }

        $funds = DB::select("WITH AliasPairs AS (
                                SELECT
                                    f1.id AS fund_id1,
                                    f2.id AS fund_id2
                                FROM
                                    funds f1
                                JOIN
                                    funds f2 ON f1.id <> f2.id 
                                    and f1.manager_id = f2.manager_id 
                                    {$query}
                                WHERE
                                    EXISTS (
                                        SELECT 1
                                        FROM jsonb_array_elements_text( (f1.aliases) ) alias1,
                                            jsonb_array_elements_text(f2.aliases) alias2
                                        WHERE alias1 = alias2
                                        or alias1 = f2.name
                                        or alias2 = f1.name
                                    )
                            )
                            SELECT DISTINCT
                                a.fund_id1,
                                f1.name AS fund_name1,
                                a.fund_id2,
                                f2.name AS fund_name2
                            FROM
                                AliasPairs a
                            JOIN
                                funds f1 ON a.fund_id1 = f1.id
                            JOIN
                                funds f2 ON a.fund_id2 = f2.id;");

        return $funds;
    }
}
