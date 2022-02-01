<?php

use App\Coupon;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('slug', 'coupons');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'coupons',
                'display_name_singular' => 'coupon',
                'display_name_plural'   => 'coupons',
                'icon'                  => 'voyager-bag',
                'model_name'            => 'App\\Coupon',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        //Data Rows
        $postDataType = DataType::where('slug', 'coupons')->firstOrFail();
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

        $dataRow = $this->dataRow($postDataType, 'code');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'code',
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

        $dataRow = $this->dataRow($postDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => 'type',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    "default" => "fixed_value",
                    "options" => [
                        "fixed_value" => "Fixed Value",
                        "percent_off" => "Percent Off"
                    ],
                    'validation' => [
                        'rule'  => 'required|string|in:fixed_value,percent_off',
                    ],
                ],
                'order'        => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'fixed_value');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'fixed_value',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'nullable|numeric',
                    ],
                ],
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'percent_off');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'percent_off',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'nullable|numeric',
                    ],
                ],
                'order'        => 5,
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
                'order'        => 6,
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
                'order'        => 7,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'coupons',
            'url'     => '',
            'route'   => 'voyager.coupons.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-dollar',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 6,
            ])->save();
        }

        //Permissions
        Permission::generateFor('coupons');


        Coupon::create([
        	'code' => 'ABC123',
        	'type' => Coupon::FIXED_VALUE,
        	'fixed_value' => 20
        ]);

        Coupon::create([
        	'code' => 'DEF456',
        	'type' => Coupon::PERCENT_OFF,
        	'percent_off' => 10
        ]);
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
