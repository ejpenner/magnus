<?php
/**
 * Categories are for classifying opus in a more structured way than tagging
 * An opus can have up to four categories depending on the category tree
 *
 * Categories can have a parent category or be a subcategory
 */
namespace Magnus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = ['open'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * A Category has many opus in it, and opus can belong to multiple categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opera()
    {
        return $this->belongsToMany('Magnus\Opera', 'category_opus')->withTimestamps();
    }

    /**
     * Categories may belong to other categories as a subcategory, this returns
     * the parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo('Magnus\Category', 'parent_category_id');
    }

    /**
     * A category can have many subcategories, this gets the child categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childCategories()
    {
        return $this->hasMany('Magnus\Category', 'parent_category_id', 'id');
    }

    protected function setSlug($value)
    {
        $this->slug = str_slug(strtolower($value));
    }
}
