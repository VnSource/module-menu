<?php namespace VnsModules\Menu;

class Menu extends \Models\Term {

    protected $fillable = ['name', 'slug', 'title', 'target', 'order', 'parent', 'status'];

    public function childrens()
    {
        return $this->hasMany('VnsModules\Menu\Menu', 'parent');
    }
}
