<?php namespace VnsModules\Menu\Controllers\Backend;

use Illuminate\Http\Request;
use VnsModules\Menu\MenuRequest;
use VnsModules\Menu\MenuRepositoryInterface as MenuRepository;

class MenuController extends \App\Http\Controllers\Controller
{
    protected $menus;

    public function __construct(MenuRepository $menus)
    {
        $this->menus = $menus;
    }

    public function index(Request $request)
    {
        list($menus, $total) = $this->menus->filter($request->only('filter','sorting'));
        return response()->json($menus)->header('total', $total);
    }

    public function show($id)
    {
        $menu = $this->menus->find($id);
        return response()->json(array_merge($menu->toArray(),['title'=>$menu->title,'target'=>$menu->target]));
    }

    public function store(MenuRequest $request)
    {
        $input = $request->all();
        $input['order'] = $this->menus->getCount() + 1;
        $menu = $this->menus->create($input);
        return response()->json($menu);
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = $this->menus->update($id, $request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = $this->menus->delete($id);
        return response()->json($menu);
    }

    public function sortMenu(Request $request) {
        $menus = $request->input('data');
        foreach ($menus as $key => $id) {
            $this->menus->update($id, ['order'=>$key+1]);
        }
        return response()->json(['success' => true]);
    }
}
