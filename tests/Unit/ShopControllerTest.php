<?php

namespace Tests\Feature;

use App\Http\Controllers\ShopController;
use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

     // テスト前の準備作業(viewで必要なREQUEST_URIを設定)
    public function setUp() :void
    {
        $_SERVER['REQUEST_URI'] = 'http://www.example.com';
        parent::setUp();
    }

    // 飲食店一覧ページ表示
    public function test_index()
    {
        // 検索条件を指定せずにアクセス
        $response = $this->get('/');
        $this->assertEquals(20,count($response['shops']));  // 全shopレコード(20件)取得を確認
        $this->assertEquals(3, count($response['areas']));  // 検索フォーム項目用areaレコード(3件)取得を確認
        $this->assertEquals(5, count($response['genres'])); // 検索フォーム項目用genreレコード(5件)取得を確認
        $response->assertStatus(200);

        // 検索条件 area_id =13
        $response = $this->get('/?area_id=13');
        $expected = Shop::where('area_id',13)->count(); // Shops tebleのarea_id=13のレコード数を取得
        $this->assertEquals($expected, count($response['shops']));
        $response->assertStatus(200);

        // 検索条件 genre_id =1
        $response = $this->get('/?genre_id=1');
        $expected = Shop::where('genre_id', 1)->count(); // Shops tebleのgenre_id=1のレコード数を取得
        $this->assertEquals($expected, count($response['shops']));
        $response->assertStatus(200);

        // 検索条件 shop_name ='仙人'
        $response = $this->get('/?shop_name=仙人');
        $expected = Shop::where('name', 'LIKE', "%仙人%")->count(); // Shops tebleのnameに'仙人'を含むレコード数を取得
        $this->assertEquals($expected, count($response['shops']));
        $response->assertStatus(200);
    }

    // index
    public function test_index_login()
    {
        // ログイン状態でアクセス
        $user = User::create([  // ユーザーを作成
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);
        $this->actingAs($user); // ログイン

        // ダミー用User作成
        $dummy = User::create([  // ユーザーを作成
            'name' => 'bbb',
            'email' => 'ddd@ccc.com',
            'password' => 'test12345'
        ]);

        // favoriteレコードを2件挿入
        // user_id = $user->id; shop_id = 存在するshopレコードの最も若いid;
        $shop = Shop::first();
        $favorite = Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
        // user_id = $dummy->id; shop_id = 存在するshopレコードの最も若いid;
        Favorite::create([
            'user_id' => $dummy->id,
            'shop_id' => $shop->id,
        ]);
        $this->assertNotEquals($dummy->id, $user->id);   // テスト用IDがユーザーIDと異なることを確認

        $response = $this->get('/');
        // id = 1の飲食店のお気に入りレコードが取得されていることを確認
        $this->assertEquals($favorite->id, $response['shops'][0]->favorites[0]->id);
        // id = 2の飲食店のお気に入りレコード(user_id = $dummy->id)が取得されていないことを確認
        $this->assertEmpty($response['shops'][1]->favorites);
    }

    // 飲食店詳細ページ
    public function test_detail()
    {
        // id番号が最も若いshopレコード情報を取得
        $shop = Shop::first();

        // $shopの飲食店詳細ページを表示
        $response = $this->get("/detail/{$shop->id}");
        $response->assertStatus(200);
        $response->assertSee($shop->name);

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
