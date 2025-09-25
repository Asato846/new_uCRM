<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('items')->insert([
		[
                    'name' => '販売仲介受取証書',
		    'author' => '加藤直樹',
		    'memo' => 'aaa3',
		    'price' => 1000,
		    'is_selling' => true,
		    'image_id' => 'aaa.png'
		],
		[
                    'name' => '逆上の照会状',
                    'author' => '鈴木均',
                    'memo' => 'bbb3',
                    'price' => 900,
                    'is_selling' => true,
                    'image_id' => 'bbb.png'
		],
		[
                    'name' => '欠航の旧話',
                    'author' => '四阿 メックス',
                    'memo' => 'ccc3',
                    'price' => 800,
                    'is_selling' => true,
                    'image_id' => 'ccc.png'
		],
		[
                    'name' => '鶩旧本',
                    'author' => 'イオイメ ベリスフォード 牧男',
                    'memo' => 'ddd3',
                    'price' => 700,
                    'is_selling' => true,
                    'image_id' => 'ddd.png'
		],
                [
                    'name' => '柄脇のフェアリーテール',
                    'author' => 'ロードストレーム 賢虎',
                    'memo' => 'eee3',
                    'price' => 1200,
                    'is_selling' => true,
                    'image_id' => 'eee.png'
                ],
                [
                    'name' => '藤間門の天史',
                    'author' => 'ジンキンズ 瑛麻 ヌノ',
                    'memo' => 'fff3',
                    'price' => 1300,
                    'is_selling' => true,
                    'image_id' => 'fff.png'
                ],
                [
                    'name' => '細幣の新紙',
                    'author' => 'オフチニコフ 親猛',
                    'memo' => 'gggg3',
                    'price' => 1400,
                    'is_selling' => true,
                    'image_id' => 'ggg.png'
                ],
                [
                    'name' => 'フォボセビ嘆きの珍談',
                    'author' => 'Allen Cardiff',
                    'memo' => 'hhh3',
                    'price' => 1500,
                    'is_selling' => true,
                    'image_id' => 'hhh.png'
                ],
                [
                    'name' => 'iii1',
                    'author' => 'iii2',
                    'memo' => 'iii3',
                    'price' => 700,
                    'is_selling' => true,
                    'image_id' => 'iii.png'
                ]
            ]);
    }
}
