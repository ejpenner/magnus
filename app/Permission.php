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

    protected $casts = [
      'create' => 'boolean',
      'read' => 'boolean',
      'edit' => 'boolean',
      'destroy' => 'boolean',
      'create_all' => 'boolean',
      'read_all' => 'boolean',
      'edit_all' => 'boolean',
      'destroy_all' => 'boolean',
    ];
    
    public function getSchemaName()
    {
        return $this->attributes['schema_name'];
    }
    
    
    
    public function users() {
        return $this->hasMany('App\User');
    }
}
