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
        return view('Product.welcome', compact('Products', 'companies'));
    }
    
    
    
    public function show($id)
    {//詳細ページの閲覧
        $Product = Product::find($id);
        return view('Product.show', compact('Product'));
    }

    public function newCreate(Request $request)
    {//登録画面処理
        return view('Product.create');
    }
    
    public function edit($id)
    {//レコード編集画面
        $Product = Product::find($id);
        return view('Product.edit',compact('Product'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'company_name' => 'required|string',
            'comment' => 'nullable|max:1000', 
            'image_path' => 'nullable|image|max:2048',
        ]);
    
        $Product = Product::findOrFail($id);
    
        // 画像ファイルが存在する場合の処理
        if ($request->hasFile('image_path')) {
            // 古い画像が存在するか確認し、存在する場合は削除
            if ($Product->image_path && File::exists(public_path('images/' . $Product->image_path))) {
                File::delete(public_path('images/' . $Product->image_path));
            }
            $file = $request->file('image_path');
            $imageName = time() . '.' . $file->getClientOriginalExtension(); // 新しいファイル名を生成
            $file->move(public_path('images'), $imageName); // アップロードされたファイルをpublic/imagesディレクトリに移動
            $Product->image_path = $imageName; // 移動後のファイル名をデータベースに保存
        }
    
        // Company情報の更新または作成
        $company = Company::firstOrCreate([
            'company_name' => $validated['company_name']
        ]);
    
        // Productモデルのcompany_idを更新
        $Product->company_id = $company->id;
        
        // company_nameを除外してProduct情報を更新
        $Product->product_name = $validated['product_name'];
        $Product->price = $validated['price'];
        $Product->stock = $validated['stock'];
        $Product->comment = $validated['comment'] ?? ''; // nullの場合は空文字を設定
        
        $Product->save();
    
        // フラッシュメッセージをセッションに追加（成功したことをユーザーに知らせる）
        session()->flash('success', '商品情報が更新されました。');
    
        return redirect()->route('Product.welcome'); // 適切なリダイレクト先に修正
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'company_name' => 'required|max:255',
            'comment' => 'max:1000', // コメントはオプショナルと仮定
            'image_path' => 'required|image|max:2048', // 画像を必須、ファイルタイプを画像、最大2MBに制限
        ]);
    
        // 画像の処理
        if ($request->hasFile('image_path')) {
            $imageName = time().'.'.$request->image_path->extension(); // 一意のファイル名
            $request->image_path->move(public_path('images'), $imageName); // ファイルを保存
            $validatedData['image_path'] = $imageName; // 保存したファイル名を追加
        }
    
        // companies テーブルに会社データを挿入
        $company = Company::firstOrCreate([
            'company_name' => $validatedData['company_name']
        ]);
    
        // products テーブルに製品データを挿入
        $product = new Product;
        $product->company_id = $company->id; // Company モデルから取得した id をセット
        $product->product_name = $validatedData['product_name'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->comment = $validatedData['comment'] ?? null;
        $product->image_path = $validatedData['image_path'];
    
        $product->save();
    
        return redirect('Product.welcome');
    }

    public function destroy($id) 
    {//レコード削除処理
        $Products = Product::find($id);
        $Products->delete(); 
        return redirect("Product.welcome"); 
    }
}
