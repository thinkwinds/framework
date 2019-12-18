<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->tinyInteger('isopen', false)->default(0)->nullable()->comment(tw_lang('thinkwinds::public.status'));
            $table->tinyInteger('header', false)->default(0)->nullable()->comment();
            $table->tinyInteger('footer', false)->default(0)->nullable()->comment();
            $table->string('title')->nullable()->comment();
            $table->string('keywords')->nullable()->comment();
            $table->string('description')->nullable()->comment();
            $table->string('domain')->nullable()->comment();
            $table->string('style')->nullable()->comment();
            $table->string('dir')->nullable()->comment();
            $table->string('module')->nullable()->comment();
            $table->text('content')->nullable()->comment();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('special');
    }
}
