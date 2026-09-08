<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Client;
use App\Models\Admin\Order;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $UsersCount = User::count();
        $clientsCount = Client::count();
        $ordersCount = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        return view('admin.index', compact(
            'categoriesCount',
            'productsCount',
            'UsersCount',
            'clientsCount',
            'ordersCount',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'cancelledOrders'
        ));
    }
}
