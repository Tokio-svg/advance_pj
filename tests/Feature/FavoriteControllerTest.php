<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

// お気に入り登録、解除処理のテスト
class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

    // 非ログイン状態でアクセス
    public function test_guest()
    {
        // create(お気に入り登録処理)
        $response = $this->post('/favorite');
        $response->assertRedirect('/login');

        // delete(お気に入り解除処理)
        $response = $this->post('/favorite/delete');
        $response->assertRedirect('/login');
    }

    // ログイン状態でアクセス
    public function test_login()
    {
        $user = User::create([  // ユーザーを作成
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);
        $this->actingAs($user); // ログイン

        $shop_id = 1;   // 登録対象のshopのidを1とする
        $url = '/'; // 遷移元のURLを'/'とする
        $position = 0;   // 遷移元のスクロール位置を0とする

        // create(お気に入り登録処理)
        $response = $this->post('/favorite',[
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'url' => $url,
            'position' => $position,
        ]);

        $response->assertRedirect($url);    // $urlにリダイレクトされることを確認
        $response->assertSessionHas('position', 0); // セッションにスクロール位置が格納されていることを確認
        $this->assertDatabaseHas('favorites', [ // 想定されるレコードが存在することを確認
            'user_id' => $user->id,
            'shop_id' => $shop_id,
        ]);

        // delete(お気に入り解除処理)
        $response = $this->post('/favorite/delete', [
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'url' => $url,
            'position' => $position,
        ]);

        $response->assertRedirect($url);    // $urlにリダイレクトされることを確認
        $response->assertSessionHas('position', 0); // セッションにスクロール位置が格納されていることを確認
        $this->assertDatabaseMissing('favorites', [ // 想定されるレコードが存在しないことを確認
            'user_id' => $user->id,
            'shop_id' => $shop_id,
        ]);
    }
}
