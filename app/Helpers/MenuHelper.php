<?php

use Illuminate\Support\Facades\Auth;

/**
 * Admin Menu
 *
 * All menu items available in the system
 * to add submenu items add another element to array in the relevant place (order) and set type="submenu", sidemenu.blade doesn't support this yet
 */
if (!function_exists('getMenuItems')) {
    function getMenuItems()
    {
        $menuItems = [
            [
                'label' => 'Admin',
                'url'   => 'admin',
                'icon'  => 'fa fa-file-text',
                'permission' => 'Admin List',
                'subItems' => [
                    [
                        'label' => 'Users',
                        'url'   => 'admin/users',
                        'icon'  => 'fa fa-file-text',
                        'permission' => 'User List',
                    ],
                    [
                        'label' => 'Roles',
                        'url'   => 'admin/roles',
                        'icon'  => 'fa fa-file-text',
                        'permission' => 'Roles List',
                    ],
                    [
                        'label' => 'Inquiry',
                        'url'   => 'admin/inquiry',
                        'icon'  => 'fa fa-file-text',
                        'permission' => 'Inquiry List',
                    ],
                    [
                        'label' => 'Customer',
                        'url'   => 'admin/customer',
                        'icon'  => 'fa fa-file-text',
                        'permission' => 'Customer List',
                    ],
                    [
                        'label' => 'Price Master',
                        'url'   => 'admin/price',
                        'icon'  => 'fa fa-file-text',
                        'permission' => 'Price List',
                    ],
                ]
            ],
            
        ];

        return $menuItems;
    }
}

if (!function_exists('getCurrentMenuRoute')) {
    function getCurrentMenuRoute()
    {
        $segments = request()->segments();
        $segmentCount = count($segments);
    
        $currentRoute = '';
    
        switch ($segmentCount) {
            case 1:
                $currentRoute = $segments[0];
                break;
            case 2:
                $currentRoute = $segments[0] . '/' . $segments[1];
                break;
            case 3:
                $currentRoute = $segments[0] . '/' . $segments[1] . '/' . $segments[2];
                break;
            case 4:
                $currentRoute = $segments[0] . '/' . $segments[1] . '/' . $segments[2] . '/' . $segments[3];
                break;
            default:
                $currentRoute = implode('/', $segments);
                break;
        }
    
        return $currentRoute;
    }    
}
