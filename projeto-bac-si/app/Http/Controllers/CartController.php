<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        // Busca todos os produtos no banco de dados
        $products = Product::all();

        // Retorna a view 'dashboard' e passa a variável 'products' para ela
        return view('dashboard', ['products' => $products]);
    }

    /**
     * Adiciona um item ao carrinho (DE FORMA VULNERÁVEL).
     */
    public function add(Request $request)
    {
        // VALIDAÇÃO BÁSICA (só para o produto)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            // Note que NÃO estamos validando o user_id
        ]);

        // ==========================================================
        // A VULNERABILIDADE (IDOR) ESTÁ AQUI
        // ==========================================================
        // Em vez de usar Auth::id() para pegar o usuário logado,
        // vamos confiar cegamente no 'user_id' que vier da requisição.
        
        $userId = $request->input('user_id'); // <-- O ATACANTE PODE MUDAR ISSO
        $productId = $request->input('product_id');

        // Se o atacante não mandar um 'user_id', usamos o do usuário logado
        // só para o app não quebrar no uso normal.
        if (!$userId) {
            $userId = $request->user()->id;
        }

        // ==========================================================

        // Lógica simples para adicionar ou incrementar o item
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Se já existe, apenas incrementa a quantidade
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Se não existe, cria o novo item no carrinho
            CartItem::create([
                'user_id' => $userId, // <-- AQUI A FALHA É EXPLORADA
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // Redireciona de volta (ou retorna um JSON, mas para Blade é mais fácil assim)
        return back()->with('message', 'Produto adicionado ao carrinho!');
    }
}
