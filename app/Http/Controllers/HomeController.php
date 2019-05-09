<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->with(['topupBalance', 'product'])
                    ->paginate(20);

        return view('home', compact(
            'orders'
        ));
    }

    public function search(Request $request)
    {
        if(strlen($request->search) == 0)
            return redirect('/');

        return redirect('/search/'.$request->search);
    }

    public function searchResult($search)
    {
        if(strlen($search) == 0)
            return redirect('/');

        $orders = Order::where('user_id', Auth::user()->id)
                    ->where('order_no', 'like', '%'.$search.'%')
                    ->orderBy('created_at', 'desc')
                    ->with(['topupBalance', 'product'])
                    ->paginate(20);

        return view('home', compact(
            'orders',
            'search'
        ));
    }
}
