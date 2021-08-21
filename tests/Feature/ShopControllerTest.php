<?php

namespace Tests\Feature;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

    // 飲食店一覧ページ表示
    public function test_index()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // 飲食店詳細ページ
    public function test_detail()
    {
        // テスト用のshopレコードを作成
        $shop = Shop::create([
            'name' => 'test_shop',
            'area_id' => 1,
            'genre_id' => 1,
            'overview' => 'test_text',
            'image_url' => 'test_url',
        ]);
        // テスト用の飲食店詳細ページを表示
        $response = $this->get("/detail/{$shop->id}");
        $response->assertStatus(200);
        $response->assertSee('test_shop');

        // idを指定せずにアクセス
        $response = $this->get('/detail');
        $response->assertStatus(404);

        // 存在しないidを指定してアクセス
        $response = $this->get('/detail/1000');
        $response->assertStatus(404);
    }

    // マイページ
    public function test_mypage()
    {
        // 非ログイン状態でアクセス
        $response = $this->get('/mypage');
        $response->assertRedirect('/login');

        // ログイン状態でアクセス
        $user = User::create([  // ユーザーを作成
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);
        $this->actingAs($user); // ログイン

        $response = $this->get('/mypage');
        $response->assertStatus(200);
    }
}
