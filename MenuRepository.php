<?php namespace VnsModules\Menu;

use Repositories\Term\TermRepository;

class MenuRepository extends TermRepository implements MenuRepositoryInterface
{
    public function getModel()
    {
        return Menu::class;
    }
}