<?php

use App\Category;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('slug', 'categories');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'categories',
                'display_name_singular' => 'category',
                'display_name_plural'   => 'categories',
                'icon'                  => 'voyager-bag',
                'model_name'            => 'App\\Category',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        //Data Rows
        $postDataType = DataType::where('slug', 'categories')->firstOrFail();
        $dataRow = $this->dataRow($postDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'id',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'name',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required|string',
                    ],
                ],
                'order'        => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'slug');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'slug',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required|string',
                    ],
                ],
                'order'        => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'created_at',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'updated_at',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 5,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'categories',
            'url'     => '',
            'route'   => 'voyager.categories.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-categories',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 5,
            ])->save();
        }

        //Permissions
        Permission::generateFor('categories');


        // Create dummy categories
        factory(Category::class)->create(['name' => 'Laptops', 'slug' => 'laptops']);
        factory(Category::class)->create(['name' => 'Desktops', 'slug' => 'desktops']);
        factory(Category::class)->create(['name' => 'Cameras', 'slug' => 'cameras']);
        factory(Category::class)->create(['name' => 'Iphones', 'slug' => 'iphones']);
        factory(Category::class)->create(['name' => 'Tablets', 'slug' => 'tablets']);
    }

    /**
     * [post description].
     *
     * @param [type] $slug [description]
     *
     * @return [type] [description]
     */
    protected function findPost($slug)
    {
        return Post::firstOrNew(['slug' => $slug]);
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
