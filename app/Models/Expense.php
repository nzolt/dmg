<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'expenses';

    protected $primaryKey = '_id';

    protected $fillable = [
        'description',
        'value',
        'info'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
        ];

    public $timestamps = true;

    public function _toArray()
    {
        return [
            'description' => $this->description,
            'value' => $this->value,
            'info' => $this->info,
            ];
    }

}
