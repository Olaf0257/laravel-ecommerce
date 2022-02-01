<?php

use App\Product;
use App\Category;
use TCG\Voyager\Models\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('slug', 'products');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'products',
                'display_name_singular' => 'product',
                'display_name_plural'   => 'products',
                'icon'                  => 'voyager-bag',
                'model_name'            => 'App\\Product',
                'policy_name'           => '',
                'controller'            => 'App\\Http\\Controllers\\Voyager\\ProductsController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        //Data Rows
        $postDataType = DataType::where('slug', 'products')->firstOrFail();
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

        $dataRow = $this->dataRow($postDataType, 'details');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'details',
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

        $dataRow = $this->dataRow($postDataType, 'quantity');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'quantity',
                'required'     => 1,
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
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'price');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'price',
                'required'     => 1,
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
                'order'        => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'rich_text_box',
                'display_name' => 'description',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'string',
                    ],
                ],
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'main_image');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'image',
                'display_name' => 'main_image',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'image',
                    ],
                ],
                'order' => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'images');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'multiple_images',
                'display_name' => 'images',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation' => [
                        'rule'  => 'image',
                    ],
                ],
                'order' => 8,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'featured');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'checkbox',
                'display_name' => 'featured',
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
                'order'        => 9,
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
                'order'        => 10,
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
                'order'        => 11,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'products',
            'url'     => '',
            'route'   => 'voyager.products.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-bag',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 3,
            ])->save();
        }

        //Permissions
        Permission::generateFor('products');


        // Create dummy products
        $laptopsCategory = Category::where('name', 'Laptops')->first();
        $desktopsCategory = Category::where('name', 'Desktops')->first();
        $camerasCategory = Category::where('name', 'Cameras')->first();
        $iphonesCategory = Category::where('name', 'Iphones')->first();
        $tabletsCategory = Category::where('name', 'Tablets')->first();

        $laptops = factory(Product::class, 10)->create();
        $i = 1;
        foreach ($laptops->fresh() as $laptop) {
            $laptop->update([
                'name' => 'HP Laptop ' . $i,
                'details' => '14 - 14" HD Non-Touch Intel Pentium Silver N5000, Intel UHD Graphics 605, 4GB RAM, 64GB eMMC, WiFi, Bluetooth, Audio by B&O, Chrome OS',
                'description' => '14" diagonal HD, anti-glare, micro-edge, WLED-backlit, 220 nits, 45% NTSC (1366 x 768)
                Intel Pentium Silver N5000 (1.1 GHz base frequency, up to 2.7 GHz burst frequency, 4 MB L2 cache, 4 cores)
                4 GB LPDDR4-2400 SDRAM (onboard), 64 GB eMMC
                2 SuperSpeed USB Type-C 5Gbps signaling rate (USB Power Delivery, DisplayPort 1.2); 1 SuperSpeed USB Type-A 5Gbps signaling rate; 1 headphone/microphone combo, Realtek Wi-Fi 5 (2x2) and Bluetooth 5 combo
                32.57 x 21.85 x 1.78 cm, 1.46 kg, HP Wide Vision HD Camera with integrated dual array digital microphone, Audio by B&O; Dual speakers, chrome OS',
                'main_image' => 'basic/laptops/laptop1_hp1.jpg',
                'images' => '["basic\/laptops\/laptop1_hp2.jpg","basic\/laptops\/laptop1_hp3.jpg","basic\/laptops\/laptop1_hp4.jpg","basic\/laptops\/laptop1_hp5.jpg"]',
            ]);

            if ($i < 9) {
                $laptop->update([
                    'created_at' => Carbon::create(2020, 12, 1, 0, 0, 0)->toDateTimeString()
                ]);
            }
            $i++;

            $laptop->categories()->attach($laptopsCategory);
        }

        $desktops = factory(Product::class, 10)->create();
        $i = 1;
        foreach ($desktops->fresh() as $desktop) {
            $desktop->update([
                'name' => 'Acer Aspire Desktop ' . $i,
                'details' => '10th Gen Intel Core i5-10400 6-Core Processor, 12GB 2666MHz DDR4, 512GB NVMe M.2 SSD, 8X DVD, 802.11ax Wi-Fi 6, USB 3.2 Type C, Windows 10 Home ',
                'description' => '10th Generation Intel Core i5-10400 6-Core Processor (Up to 4.3GHz)
                12GB 2666MHz DDR4 Memory | 512GB NVMe M.2 SSD | 8X DVD-Writer Double-Layer Drive (DVD-RW)
                Intel Wireless Wi-Fi 6 AX200 802.11ax Dual-Band 2.4GHz and 5GHz featuring 2x2 MU-MIMO technology | Bluetooth 5.1 | 10/100/1000 Gigabit Ethernet LAN
                1 - USB 3.2 Type C Gen 1 port (up to 5 Gbps) (Front) | 5 - USB 3.2 Gen 1 Ports (1 Front and 4 Rear) | 2 - USB 2.0 Ports (Rear) | 2 - HDMI Ports
                Windows 10 Home (USB Keyboard and Mouse Included)',
                'main_image' => 'basic/desktops/desktop1_acer1.jpg',
                'images' => '["basic\/desktops\/desktop1_acer2.jpg","basic\/desktops\/desktop1_acer3.jpg","basic\/desktops\/desktop1_acer4.jpg"]'
            ]);

            if ($i < 9) {
                $desktop->update([
                    'created_at' => Carbon::create(2020, 12, 1, 0, 0, 0)->toDateTimeString()
                ]);
            }
            $i++;

            $desktop->categories()->attach($desktopsCategory);
        }

        $cameras = factory(Product::class, 10)->create();
        $i = 1;
        foreach ($cameras->fresh() as $camera) {
            $camera->update([
                'name' => 'Digital Camera ' . $i,
                'details' => '4K Digital Camera, Video Camera Camcorder VideoSky UHD 48MP with WiFi 3.5 in Touch Screen 16 X Digital Zoom Wide Angle Lens YouTube Vlogging Cameras',
                'description' => '4K 48MP Digital Camera with Touch Screen】Our digital camera is crystal and clear in image shooting and video. It records video up to 4K FHD 24 fps resolution. It can shoots picture at 48.0 megapixels. The 3.5" IPS touch screen allows for higher-definition display, and the touch screen makes operation more easier.The better shootting distance should more than 1 meter.
【Video camera with WiFi Connection】This 4k camcorder with Wifi function can connect to your phone without any cable. It can be used as a webcam. Connect the camcorder to your computer via USB cable and select PC Camera mode. Then you can start the live stream!! And it supports connect to TV with HDMI cable and playback the videos you took in high definition. ',
                'main_image' => 'basic/cameras/camera11.jpg',
                'images' => '["basic\/cameras\/camera12.jpg","basic\/cameras\/camera13.jpg","basic\/cameras\/camera14.jpg"]'
            ]);

            if ($i < 9) {
                $camera->update([
                    'created_at' => Carbon::create(2020, 12, 1, 0, 0, 0)->toDateTimeString()
                ]);
            }
            $i++;

            $camera->categories()->attach($camerasCategory);
        }

        $iphones = factory(Product::class, 10)->create();
        $i = 1;
        foreach ($iphones->fresh() as $iphone) {
            $iphone->update([
                'name' => 'Apple iPhone 11 Pro ' . $i,
                'details' => '64GB, Midnight Green - Fully Unlocked (Renewed)',
                'description' => '10 Inch Android 9.0 3G Phone Tablets with 32GB Storage Dual Sim Card 5MP Camera, WiFi, Bluetooth, GPS, Quad Core, HD Touchscreen, Support 3G Phone Call (Black)',
                'main_image' => 'basic/iphones/iphone1_11pro1.jpg',
                'images' => '["basic\/iphones\/iphone1_11pro2.jpg","basic\/iphones\/iphone1_11pro3.jpg","basic\/iphones\/iphone1_11pro4.jpg"]'
            ]);

            if ($i < 9) {
                $iphone->update([
                    'created_at' => Carbon::create(2020, 12, 1, 0, 0, 0)->toDateTimeString()
                ]);
            }
            $i++;

            $iphone->categories()->attach($iphonesCategory);
        }

        $tablets = factory(Product::class, 10)->create();
        $i = 1;
        foreach ($tablets->fresh() as $tablet) {
            $tablet->update([
                'name' => 'Tablet ' . $i,
                'details' => '10 Inch Android 9.0 3G Phone Tablets with 32GB Storage Dual Sim Card 5MP Camera, WiFi, Bluetooth, GPS, Quad Core, HD Touchscreen, Support 3G Phone Call (Black)',
                'description' => '3G Phone Call & 2.4G WIFI Connect】---The newest tablet support 2pcs phone card insertion, enable you to call or send massages to anyone anywhere anytime even without wifi. The wifi connection perfect for fast connecting network .
                【Incredible Storage】---- Featuring with 32GB internal Storage, (MicroSD Expandable to 128GB), it is perfect for running a mass of entertainment apps fluently, such as Youtube, Instagram, Skype, etc.
                【Excellent in Fast Response】---Featuring Android 9.0 operating system of four high-performance 1.3 GHz Quad Core CPU, ensures an ultra-smooth gaming and speedy multimedia using experience.',
                'main_image' => 'basic/tablets/tablet11.jpg',
                'images' => '["basic\/tablets\/tablet12.jpg","basic\/tablets\/tablet13.jpg","basic\/tablets\/tablet14.jpg"]'
            ]);

            if ($i < 9) {
                $tablet->update([
                    'created_at' => Carbon::create(2020, 12, 1, 0, 0, 0)->toDateTimeString()
                ]);
            }
            $i++;

            $tablet->categories()->attach($tabletsCategory);
        }
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
