<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function getMenuData()
    {
        $menuGroups = [
            [
                'title' => 'Menu',
                'items' => [
                    [
                        'icon' => 'grid-icon',
                        'name' => 'Dashboard',
                        'path' => '/dashboard',
                    ],
                    [
                        'icon' => 'calendar-icon',
                        'name' => 'Calendar',
                        'path' => '/calendar',
                    ],
                    [
                        'icon' => 'user-circle-icon',
                        'name' => 'User Profile',
                        'path' => '/profile',
                    ],
                    [
                        'icon' => 'table-icon',
                        'name' => 'Tables',
                        'subItems' => [
                            ['name' => 'Basic Tables', 'path' => '/basic-tables', 'pro' => false],
                            ['name' => 'Data Tables', 'path' => '/data-tables', 'pro' => false],
                        ],
                    ],
                    [
                        'icon' => 'page-icon',
                        'name' => 'Pages',
                        'subItems' => [
                            ['name' => 'File Manager', 'path' => '/file-manager', 'pro' => false],
                            ['name' => 'Pricing Tables', 'path' => '/pricing-tables', 'pro' => false],
                            ['name' => 'Faqs', 'path' => '/faq', 'pro' => false],
                            ['name' => 'API Keys', 'path' => '/api-keys', 'new' => true],
                            ['name' => 'Integrations', 'path' => '/integrations', 'new' => true],
                            ['name' => 'Blank Page', 'path' => '/blank', 'pro' => false],
                            ['name' => '404 Error', 'path' => '/error-404', 'pro' => false],
                            ['name' => '500 Error', 'path' => '/error-500', 'pro' => false],
                            ['name' => '503 Error', 'path' => '/error-503', 'pro' => false],
                            ['name' => 'Coming Soon', 'path' => '/coming-soon', 'pro' => false],
                            ['name' => 'Maintenance', 'path' => '/maintenance', 'pro' => false],
                            ['name' => 'Success', 'path' => '/success', 'pro' => false],
                        ],
                    ],
                ],
            ],
        ];

        return view('components.sidebar', compact('menuGroups'));
    }
}
