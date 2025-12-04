<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'stock' => 'required|integer|min:0'
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (!in_array($extension, $allowedExt)) {
                    return back()->withInput()
                        ->withErrors(['image' => 'File harus berupa gambar (jpg, png, gif, dll)']);
                }
                
                if ($file->getSize() > 5242880) {
                    return back()->withInput()
                        ->withErrors(['image' => 'Ukuran file maksimal 5MB']);
                }
                
                $filename = time() . '_' . uniqid() . '.' . $extension;
                
                $uploadPath = public_path('uploads/products');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
                $validated['image'] = 'uploads/products/' . $filename;
            }

            Product::create($validated);

            return redirect()->route('product.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withInput()
                ->withErrors(['error' => 'Gagal menyimpan produk: ' . $e->getMessage()]);
        }
    }

    // Method SHOW - Detail Produk
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'stock' => 'required|integer|min:0'
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (!in_array($extension, $allowedExt)) {
                    return back()->withInput()
                        ->withErrors(['image' => 'File harus berupa gambar (jpg, png, gif, dll)']);
                }
                
                if ($file->getSize() > 5242880) {
                    return back()->withInput()
                        ->withErrors(['image' => 'Ukuran file maksimal 5MB']);
                }
                
                if ($product->image && File::exists(public_path($product->image))) {
                    File::delete(public_path($product->image));
                }
                
                $filename = time() . '_' . uniqid() . '.' . $extension;
                
                $uploadPath = public_path('uploads/products');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
                $validated['image'] = 'uploads/products/' . $filename;
            }

            $product->update($validated);

            return redirect()->route('product.index')
                ->with('success', 'Produk berhasil diupdate!');

        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()
                ->withErrors(['error' => 'Gagal mengupdate produk: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $product->delete();
            
            return redirect()->route('product.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus produk: ' . $e->getMessage()]);
        }
    }
}