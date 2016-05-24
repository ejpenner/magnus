<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    protected $fillable = [
        'schema_name',
        'role',
        'create','read','edit','destroy',
        'create_all','read_all','edit_all','destroy_all',
    ];
    
    public function getSchemaName() {
        return $this->attributes['schema_name'];
    }
}
