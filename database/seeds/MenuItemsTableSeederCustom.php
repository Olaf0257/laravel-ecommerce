<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeederCustom extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        
        // Main menu
        $menu = Menu::where('name', 'main')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Contact',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Categories',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Shop',
            'url'     => '',
            'route'   => 'shop.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 3,
            ])->save();
        }

        // Footer menu
        $menu = Menu::where('name', 'footer')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Follow Us:',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'fa-globe',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_blank',
                'icon_class' => 'fa fa-globe',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'fa-facebook',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_blank',
                'icon_class' => 'fab fa-facebook-f',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 3,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'fa-instagram',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_blank',
                'icon_class' => 'fab fa-instagram',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 4,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'fa-twitter',
            'url'     => '',
            'route'   => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_blank',
                'icon_class' => 'fab fa-twitter',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 5,
            ])->save();
        }
    }
}
