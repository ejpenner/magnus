<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'schema_name', 'role_id',
        'create','read','edit','destroy',
        'create_all','read_all','edit_all','destroy_all',
        'gallery_all','piece_all','comment_all','private_message_all',
        'private_message_access', 'banned'
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
      'gallery_all' => 'boolean',
      'piece_all' => 'boolean',
      'comment_all' => 'boolean',
      'private_message_all' => 'boolean',
      'private_message_access' => 'boolean',
      'banned' => 'boolean',
    ];
    
    public function getSchemaName()
    {
        return $this->attributes['schema_name'];
    }
    
    public function role() {
        return $this->belongsTo('App\Role');
    }

    public static function hasPermission(User $user, $permission) {
        foreach($user->roles as $userRoles) {
            foreach($userRoles->permission->attributes as $key => $value) {
                $permissions = Permission::where('schema_name', $userRoles->role_name)->value($permission);
            }
        }
        return false;
    }
}
