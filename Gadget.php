<?php namespace VnsModules\Menu;

use Cache;
use Illuminate\Support\Facades\View;

class Gadget
{
    public function register($slug) {
        if (Cache::has('gadgetMenu_'.$slug)) {
            $menus = Cache::get('gadgetMenu_'.$slug);
        } else {
            $menu = Menu::findSlug($slug);
            if (!empty($menu->id)) {
                $menus = $this->loopMenu($menu->id);
                Cache::forever('gadgetMenu_'.$slug, $menus);
            } else {
                $menus = [];
            }
        }
        if (View::exists('Frontend::gadgets.'.$slug)) {
            return view('Frontend::gadgets.'.$slug, ['menus'=>$menus]);
        } else {
            return view('VnsModules\Menu::gadget', ['menus'=>$menus]);
        }
    }

    public function loopMenu($parent) {
        $menus = Menu::where('parent', $parent)
            ->orderBy('order', 'asc')
            ->select('id', 'name', 'extend', 'slug', 'parent', 'status')
            ->get()
        ;
        if(count($menus) == 0) {
            return [];
        } else {
            $newMenus = [];
            foreach ($menus as $menu) {
                $newMenus[] = [
                    'name' => $menu->name,
                    'slug' => $menu->slug,
                    'title' => $menu->title,
                    'target' => $menu->target,
                    'childrens' => $this->loopMenu($menu['id'])
                ];
            }
            return $newMenus;
        }
    }
}
