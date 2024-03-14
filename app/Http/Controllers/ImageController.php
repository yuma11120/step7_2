<?php

namespace App\Http\Controllers;
use App\Models\step72;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
    
        // 'public/images' ディレクトリが存在するか確認し、存在しない場合は作成
        $directory = public_path('images');
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
    
        try {
            $request->image->move($directory, $imageName); // 画像を移動
            $step72 = new Step72; // モデルのインスタンスを作成
            $step72->picture = $imageName; // 画像名をモデルに保存
            $step72->save(); // データベースに保存
        } catch (\Exception $e) {
            return redirect('/step7.create')->withErrors('ファイルのアップロードに失敗しました。');
        }
    
        return redirect('/step7.create')
            ->with('success','画像がアップロードされました。')
            ->with('image', $imageName);
    }
}
