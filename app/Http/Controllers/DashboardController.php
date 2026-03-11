<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get latest products
        $latestProducts = Produk::latest()->take(6)->get();
        
        // Get user's comments count
        $userCommentsCount = Comment::where('user_id', $user->id)->count();
        
        // Get total products
        $totalProducts = Produk::count();
        
        // Get user's recent comments
        $recentComments = Comment::where('user_id', $user->id)
            ->with('produk')
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'user',
            'latestProducts',
            'userCommentsCount',
            'totalProducts',
            'recentComments'
        ));
    }
}
