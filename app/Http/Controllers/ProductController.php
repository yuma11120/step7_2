<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Fileファサードを使用
use Illuminate\Support\Facades\Log; // 必ずLogファサードをuse宣言

class ProductController extends Controller
{//もし不備があれば一括削除して最初から書き換えもあ 
    public function __construct()
    {
        $this->Products = new Product();
        $this->middleware('auth', ['only' => ['welcome']]);
    }

    public function welcome(Request $request)
    {
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');
    
        // すべてのメーカーを取得
        $companies = Company::all(); 
    
        // プロダクトクエリビルダーを取得
        $query = Product::query();
    
        // キーワードが入力されていたら商品名とメーカー名で絞り込む
        if ($keyword) {
            $query->where('product_name', 'like', "%{$keyword}%")
                ->orWhereHas('company', function ($q) use ($keyword) {
                    $q->where('company_name', 'like', "%{$keyword}%");
                });
        }
    
        // メーカーIDが選択されていたら絞り込む
        if ($company_id) {
            $query->whereHas('company', function ($q) use ($company_id) {
                $q->where('id', $company_id);
            });
        }
    
        // ページネーションを使って結果を取得
        $Products = $query->paginate(4);
    
        // リクエストされた検索条件をページネーションリンクに引き継ぐ
        if ($keyword) {
            $Products->appends(['keyword' => $keyword]);
        }
        if ($company_id) {
            $Products->appends(['company_id' => $company_id]);
        }
    
        // ビューに変数を渡す
        return view('Product.index', compact('Products', 'companies'));
    }
    
    
    
    public function show($id)
    {//詳細ページの閲覧
        $Product = Product::find($id);
        return view('Product.show', compact('Product'));
    }

    public function newCreate(Request $request)
    {//登録画面処理
        // すべてのメーカーを取得（メーカーをセレクトボックスで選択できるようにする）
        $company_id = $request->input('company_id');
        $companies = Company::all(); 
        return view('Product.create',compact('companies'));
    }
    
    public function edit(Request $request,$id)
    {//レコード編集画面
        $Product = Product::find($id);

        // すべてのメーカーを取得（メーカーをセレクトボックスで選択できるようにする）
        $company_id = $request->input('company_id');
        $companies = Company::all(); 
        return view('Product.edit',compact('Product','companies'));
    }

    public function update(Request $request, $id)
    {//更新処理
        try {
            $validated = $request->validate([
                'product_name' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'company_id' => 'required|exists:companies,id',
                'comment' => 'nullable|max:1000',
                'image_path' => 'nullable|image|max:2048',
            ]);

            $Product = Product::findOrFail($id);
            $Product->fill($validated);

            if ($request->hasFile('image_path')) {
                // 古い画像が存在する場合は削除
                $existingImagePath = public_path('images/' . $Product->image_path);
                if ($Product->image_path && File::exists($existingImagePath)) {
                    File::delete($existingImagePath);
                }
                
                // 画像を保存し、一意のファイル名を生成
                $file = $request->file('image_path');
                $imageName = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images'), $imageName);
                
                // 新しい画像名をデータベースに保存
                $Product->image_path = $imageName;
            }

            $Product->save();

            return redirect()->route('Product.index')->with('success', '商品情報が更新されました。');
        } catch (\Exception $e) {
            // エラーログに例外を記録
            \Log::error($e->getMessage());

            // エラーメッセージを表示
            return back()->withErrors('更新中にエラーが発生しました。もう一度試してください。');
        }
    }

    
    public function store(Request $request)
    {    //新規作成
        try {
            $validatedData = $request->validate([
                'product_name' => 'required|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'company_id' => 'required|exists:companies,id',
                'comment' => 'nullable|max:1000',
                'image_path' => 'required|image|max:2048',
            ]);

            if ($request->hasFile('image_path')) {
                $imageName = time().'.'.$request->image_path->extension();
                $request->image_path->move(public_path('images'), $imageName);
                $validatedData['image_path'] = $imageName;
            }

            $product = new Product($validatedData);
            $product->company_id = $validatedData['company_id'];
            $product->save();

            return redirect()->route('Product.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // エラーログに例外を記録
            \Log::error($e->getMessage());

            // 前ページにリダイレクト、エラーメッセージ表示
            return back()->withErrors('An unexpected error occurred. Please try again later.');
        }
    }

    public function destroy($id) 
    {
        try {
            // レコード削除処理
            $Product = Product::findOrFail($id);
            
            // 画像ファイルがある場合は、それも削除
            if ($Product->image_path) {
                $imagePath = public_path('images/' . $Product->image_path);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
    
            $Product->delete();
            return redirect()->route('Product.index')->with('success', '商品が正常に削除されました。');
        } catch (\Exception $e) {
            // エラーログに例外を記録
            \Log::error($e->getMessage());
    
            // ユーザーにエラーメッセージを表示
            return back()->withErrors('削除中にエラーが発生しました。もう一度試してください。');
        }
    }
    
}
