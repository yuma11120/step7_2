<?php

namespace App\Http\Controllers;
use App\Models\step72;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class step7Controller extends Controller
{//もし不備があれば一括削除して最初から書き換えもあ 
    
    public $search = '';
    public function __construct()
    {

        $this->step72s = new step72();
        $this->middleware('auth', ['only' => ['welcome']]);
    }

    public function welcome(Request $request)
    {//初期画面の表示

        //return view('step7.welcome',[
         //   'step7' => $step72s,
        //],compact('step72s'));

//$step72s = step72::query();　にするとDBのデータが表示されない、おそらくここでどうにかすれば絞り込むことが可能になる



//DBのテーブルをWHEREで指定して昇順に取得すれば標準通り表示できる可能性あり。
        $keyword = $request->input('keyword');

        if ($keyword) {
            $step72s = Step72::where('name', 'like', "%$keyword%")
                            ->orWhere('makerName', 'like', "%$keyword%")
                            ->paginate(7);
        } else {
            $step72s = Step72::paginate(7);
        }

        return view('step7.welcome', compact('step72s'));

      //  if($keyword !== null) {
      //      $step72s->where('name', 'LIKE', '%'.$keyword.'%');
      //  }else{


            }
    



    public function show($id)
    {//詳細ページの閲覧
        $step72s = step72::find($id);

        return view('step7.show', compact('step72s'));
    }

    public function newCreate(Request $request)
    {//登録画面処理
        return view('step7.create');
    }

    public function Confirm(Request $request)
    {//登録確認画面
        return view('step7.Confirm');

    }

    public function delete(Request $request)
    {//レコード削除画面
        return view('step7.delete');
    }

    public function edit($id)
    {//レコード編集画面
        $step72s = step72::find($id);

        return view('step7.edit',compact('step72s'));
    }

    public function update($id)
    {//編集画面処理
        $step72s = step72::find($id);
        return view('step7.update',compact('step72s'));
    }

    public function destroy($id) 
    {//レコード削除処理
        $step72s = step72::find($id);
        $step72s->delete(); 
        return redirect("step7.welcome"); 
    }
    public function signUp(Request $request)
    {//登録処理
        return view('step7.signUp');
    }

    public function register(Request $request) {
        //会員登録処理
        return redirect('/');
    }

    public function login(Request $request) {
        //会員登録処理
        return view('step7.login');
    }

    public function loginForm(Request $request) {
        //会員登録処理
        return view('step7.loginForm');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'makerName' => 'required|max:255',
            'coment' => 'max:1000', // コメントはオプショナルと仮定
            'image' => 'required|image|max:2048', // 画像を必須、ファイルタイプを画像、最大2MBに制限
        ]);
    
        // 画像の処理
        if ($request->hasFile('image')) {
            // 画像の保存とパスの取得
            $path = $request->file('image')->store('public/images');
            // ストレージのパスから公開パスを取得
            $publicPath = Storage::url($path);
        }
    
        $step72 = new Step72;
        $step72->name = $validatedData['name'];
        $step72->makerName = $validatedData['makerName'];
        $step72->stock = $validatedData['stock'];
        $step72->price = $validatedData['price'];
        $step72->coment = $validatedData['coment'] ?? null;
        $step72->picture = $publicPath ?? null; // 画像パスを格納
    
        $step72->save();
    
        return redirect('step7.welcome')->with('success', '商品と画像が追加されました。');



    }

}
