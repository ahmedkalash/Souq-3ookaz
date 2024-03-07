<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CompareToColumnValue implements ValidationRule
{
    /**
     * Compare a value To DB table column Value <'column'> <'condition'> <'value'>
     *
     * @param string $column
     * @param string $condition can be on of the valid sql comparison operators like <,>,=,... etc
     * @param string $table
     * @param array $row_identifier [column_name, value]
     */
    public function __construct(
        protected string $column,
        protected string $condition,
        protected string $table,
        protected array $row_identifier,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        \DB::table($this->table)
            ->where($this->row_identifier[0], $this->row_identifier[1])
            ->where($this->column, $this->condition, $value)
            ->exists();
    }
}
