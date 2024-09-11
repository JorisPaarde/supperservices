<?php 
namespace App\Controllers;

use Sober\Controller\Controller;

class Product extends Controller {

    public static function productTabs() {
        $product_tabs = [
            (object)[
                'key' => 'ingredients',
                'view' => 'default',
                'data' => get_field('ingredients'),
                'label' => get_field('ingredients')['title'],
            ],
            (object)[
                'key' => 'allergens',
                'view' => 'default',
                'data' => get_field('allergens'),
                'label' => get_field('allergens')['title'],
            ],
            (object)[
                'key' => 'nutrients',
                'view' => 'nutrients',
                'data' => get_field('nutrients'),
                'label' => 'Nutrients',
            ]
        ];
        
        $extraTabs = get_field('extra_tabs');

        if (!empty($extraTabs)) {
            $index = 0;
            foreach ($extraTabs as $item) {
                $product_tabs[] = (object)[
                    'key' => "extra_tab_{$index}",
                    'data' => $item,
                    'view' => 'default',
                    'label' => $item['title'],
                ];
                $index++;
            };
        }

        return $product_tabs;
    }
}
