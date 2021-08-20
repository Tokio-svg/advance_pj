<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class AccessTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

    // アクセステスト(非ログイン状態)
    public function test_guest_access()
    {
        // 飲食店一覧ページ表示
        $response = $this->get('/');
        $response->assertStatus(200);

        // マイページ表示(正常：'/login'にリダイレクト)
        $response = $this->get('/mypage');
        $response->assertRedirect('/login');

        // 飲食店詳細ページ(id=1)表示
        $response = $this->get('/detail/1');
        $response->assertStatus(200);

        // お気に入り登録処理(正常：'/login'にリダイレクト)
        $response = $this->post('/favorite');
        $response->assertRedirect('/login');

        // お気に入り解除処理(正常：'/login'にリダイレクト)
        $response = $this->post('/favorite/delete');
        $response->assertRedirect('/login');

        // 予約登録処理(正常：'/login'にリダイレクト)
        $response = $this->post('/reserve');
        $response->assertRedirect('/login');

        // 予約取り消し処理(正常：'/login'にリダイレクト)
        $response = $this->post('/reserve/delete');
        $response->assertRedirect('/login');

        // 新規登録ページ表示
        $response = $this->get('/register');
        $response->assertStatus(200);

        // 新規登録処理

        // ログインページ表示
        $response = $this->get('/login');
        $response->assertStatus(200);

        // ログイン処理

        // 無効なアドレス
        $response = $this->get('/no_route');
        $response->assertStatus(404);
    }

    // アクセステスト(ログイン状態)
    public function test_login_access()
    {
        // ユーザーを作成
        User::factory()->create([
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);

    }
}
