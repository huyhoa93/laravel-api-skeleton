<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('病院コード')->nullable();
            $table->dateTimeTz('レコード更新日時');
            $table->integer('患者ID')->comment('h001');
            $table->string('文書番号', 30)->comment('h002');
            $table->integer('文書版数')->comment('h003');
            $table->dateTimeTz('文書日付')->comment('h004');
            $table->integer('アクティブフラグ')->nullable()->comment('h005');
            $table->integer('削除フラグ')->nullable()->comment('h006');
            $table->string('親文書番号')->nullable()->comment('h007');
            $table->string('診療科コード')->nullable()->comment('h008');
            $table->string('診療科名')->nullable()->comment('h009');
            $table->integer('入外区分コード')->nullable()->comment('h010');
            $table->string('入外区分名')->nullable()->comment('h011');
            $table->string('病棟コード')->nullable()->comment('h012');
            $table->string('病棟名')->nullable()->comment('h013');
            $table->string('作成者ID')->nullable()->comment('h014');
            $table->string('作成者名')->nullable()->comment('h015');
            $table->dateTimeTz('作成日')->nullable()->comment('h016');
            $table->string('更新者ID')->nullable()->comment('h017');
            $table->string('更新者名')->nullable()->comment('h018');
            $table->dateTimeTz('更新日')->nullable()->comment('h019');
            $table->dateTimeTz('DWH更新日時')->nullable()->comment('h020');
            $table->string('XTMファイル名')->nullable()->comment('h021');
            $table->string('文書タイトル')->nullable()->comment('h022');
            $table->string('診療科コード(テンプレート分類)')->nullable()->comment('h023');
            $table->string('診療科名称(テンプレート分類)')->nullable()->comment('h024');
            $table->string('患者氏名')->nullable()->comment('h025');
            $table->string('性別')->nullable()->comment('h026');
            $table->dateTimeTz('生年月日')->nullable()->comment('h027');
            $table->integer('年齢')->nullable()->comment('h028');
            $table->string('フォーム名', 200)->comment('m001');
            $table->string('コントロール名', 200)->comment('m002');
            $table->integer('繰返し連番')->comment('m003');
            $table->string('コントロールタイプ')->nullable()->comment('m004');
            $table->text('文字データ')->nullable()->comment('m005');
            $table->dateTimeTz('データマート更新日時')->nullable()->comment('m006');

            $table->unique(['病院コード', '文書日付', '患者ID', '文書番号', '文書版数', 'フォーム名', 'コントロール名', '繰返し連番'], 'combo_unique_template_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
