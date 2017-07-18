<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/18/2017
 * Time: 3:32 AM
 */

namespace Ignite\Inpatient\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Ignite\Core\Contracts\Authentication;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as Panda;


class SidebarExtender implements Panda
{

    protected $auth;


    /**
     * SidebarExtender constructor.
     * @param Authentication $auth
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group('Inpatient', function(Group $group){
            $group->item('Details', function(Item $item){
                $item->weight(2);
                $item->icon('fa fa-users');
            });
            $group->item('Details', function(Item $item){
                $item->weight(2);
                $item->icon('fa fa-users');
            });

        });

        return $menu;
        // TODO: Implement extendWith() method.
    }
}