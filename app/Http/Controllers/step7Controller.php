<?php

namespace App\Http\Controllers;
use App\Models\step72;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Fileファサードを使用

class step7Controller extends Controller
{//もし不備があれば一括削除して最初から書き換えもあ 
    public function __construct()
    {
        $this->step72s = new step72();
        $this->middleware('auth', ['only' => ['welcome']]);
    }

    public function welcome(Request $request)
    {//初期画面の表示
        $keyword = $request->input('keyword');
            if ($keyword) {
                $step72s = Step72::where('name', 'like', "%$keyword%")
                                ->orWhere('makerName', 'like', "%$keyword%")
                                ->paginate(4);
            } else {
                $step72s = Step72::paginate(4);
            }
        return view('step7.welcome', compact('step72s'));
    }
    
    public function show($id)
    {//詳細ページの閲覧
        $step72 = step72::find($id);
        return view('step7.show', compact('step72'));
    }

    public function newCreate(Request $request)
    {//登録画面処理
        return view('step7.create');
    }
    
    public function edit($id)
    {//レコード編集画面
        $step72 = step72::find($id);
        return view('step7.edit',compact('step72'));
    }

    public function update(Request $request,$id)
    {//編集画面処理
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'makerName' => 'required|string',
            'coment' => 'max:1000', 
            'image' => 'image|max:2048',
        ]);
        $step72 = Step72::findOrFail($id);
        // 画像ファイルが存在する場合の処理
        if ($request->hasFile('image')) {
            // 古い画像が存在するか確認し、存在する場合は削除
                if ($step72->image && File::exists(public_path('images/' . $step72->image))) {
                    File::delete(public_path('images/' . $step72->image));
                }
                $imageName = time().'.'.$request->image->extension(); // 一意のファイル名
                $request->image->move(public_path('images'), $imageName); // ファイルを保存
                $validated['image'] = $imageName; // 保存したファイル名を追加
        }
        $step72->update($validated);
        return redirect()->route('step7.welcome'); // リダイレクト先
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
            $imageName = time().'.'.$request->image->extension(); // 一意のファイル名
            $request->image->move(public_path('images'), $imageName); // ファイルを保存
            $validated['image'] = $imageName; // 保存したファイル名を追加
        }
        $step72 = new Step72;
        $step72->name = $validatedData['name'];
        $step72->makerName = $validatedData['makerName'];
        $step72->stock = $validatedData['stock'];
        $step72->price = $validatedData['price'];
        $step72->coment = $validatedData['coment'] ?? null;
        $step72->image = $imageName;

        $step72->save();
        return redirect('step7.welcome');
    }

    public function destroy($id) 
    {//レコード削除処理
        $step72s = step72::find($id);
        $step72s->delete(); 
        return redirect("step7.welcome"); 
    }
}
