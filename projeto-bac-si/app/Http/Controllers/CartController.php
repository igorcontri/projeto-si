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
        // Busca todos os produtos no banco de dados
        $products = Product::all();

        // NOVO: Busca os itens do carrinho DO USUÁRIO LOGADO
        $cartItems = CartItem::with('product') // 'product' é a relação que faremos
                            ->where('user_id', Auth::id())
                            ->get();

        // Retorna a view e passa AMBAS as variáveis
        return view('dashboard', [
            'products' => $products,
            'cartItems' => $cartItems // Passa os itens do carrinho
        ]);
    }

    /**
     * Adiciona um item ao carrinho (DE FORMA VULNERÁVEL).
     */
 public function add(Request $request)
    {
        // ATUALIZADO: Adicionada validação para a quantidade
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1' // Garante que a quantidade é pelo menos 1
        ]);

        // ==========================================================
        // A VULNERABILIDADE (IDOR) ESTÁ AQUI
        // ==========================================================
        $userId = $request->input('user_id'); // O ATACANTE PODE MUDAR ISSO
        $productId = $request->input('product_id');
        
        // ATUALIZADO: Pega a quantidade do input, com padrão 1
        $quantityToAdd = (int) $request->input('quantity', 1);

        if (!$userId) {
            $userId = $request->user()->id;
        }
        // ==========================================================

        // Lógica atualizada para adicionar a quantidade
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Se já existe, SOMA a nova quantidade
            $cartItem->quantity += $quantityToAdd;
            $cartItem->save();
        } else {
            // Se não existe, cria o item com a nova quantidade
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantityToAdd // Usa a quantidade do formulário
            ]);
        }

        return back()->with('message', 'Produto(s) adicionado(s) ao carrinho!');
    }
}
