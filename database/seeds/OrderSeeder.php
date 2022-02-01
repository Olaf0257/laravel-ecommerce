<?php

use App\Order;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('slug', 'orders');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'orders',
                'display_name_singular' => 'order',
                'display_name_plural'   => 'orders',
                'icon'                  => 'voyager-documentation',
                'model_name'            => 'App\\Order',
                'policy_name'           => '',
                'controller'            => 'App\\Http\\Controllers\\Voyager\\OrdersController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        //Data Rows
        $postDataType = DataType::where('slug', 'orders')->firstOrFail();
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

        $dataRow = $this->dataRow($postDataType, 'user_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'user_id',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'numeric|nullable',
                    ],
                ],
                'order'        => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_email');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_email',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required|email',
                    ],
                ],
                'order'        => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_phone');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_phone',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_address');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_address',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_country');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_country',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_city');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_city',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order' => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_state');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_state',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order' => 8,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'billing_postal_code');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'billing_postal_code',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 9,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipping_address');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'shipping_address',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 10,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipping_country');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'shipping_country',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 11,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipping_city');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'shipping_city',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order' => 12,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipping_state');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'shipping_state',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order' => 13,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipping_postal_code');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'shipping_postal_code',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 14,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'cc_first_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'cc_first_name',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 15,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'cc_last_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'cc_last_name',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required',
                    ],
                ],
                'order'        => 16,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'cc_phone');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'cc_phone',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 17,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'subtotal');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'subtotal',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required|numeric',
                    ],
                ],
                'order'        => 18,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'tax');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'tax',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 19,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'discount');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'discount',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 20,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'discount_code');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'discount_code',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 21,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'total');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'total',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'required|numeric',
                    ],
                ],
                'order'        => 22,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'payment_gateway');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'payment_gateway',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 23,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'shipped');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'checkbox',
                'display_name' => 'shipped',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    "on" => "Yes",
                    "off" => "No"
                ],
                'order'        => 24,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'error');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'error',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'nullable|string',
                    ],
                ],
                'order'        => 25,
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
                'order'        => 26,
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
                'order'        => 27,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'orders',
            'url'     => '',
            'route'   => 'voyager.orders.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-documentation',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        //Permissions
        Permission::generateFor('orders');
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
