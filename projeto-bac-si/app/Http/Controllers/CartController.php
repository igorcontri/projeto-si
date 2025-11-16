<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $cartItems = CartItem::with('product') // 'product' é a relação que faremos
                            ->where('user_id', Auth::id())
                            ->get();

        return view('dashboard', [
            'products' => $products,
            'cartItems' => $cartItems 
        ]);
    }

    public function add(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1' 
        ]);

        $userId = $request->input('user_id');  //Modo Vunerável 
        // $userId = Auth::id(); // Modo Seguro

        $productId = $request->input('product_id');
        
        $quantityToAdd = (int) $request->input('quantity', 1);

        if (!$userId) {
            $userId = $request->user()->id;
        }

        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantityToAdd;
            $cartItem->save();
        } else {

            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantityToAdd
            ]);
        }

        return back()->with('message', 'Produto(s) adicionado(s) ao carrinho!');
    }
}
