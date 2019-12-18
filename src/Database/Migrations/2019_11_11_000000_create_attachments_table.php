<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('aid')->comment('AID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->string('type')->nullable()->comment();
            $table->integer('size')->nullable()->comment('size');
            $table->string('path')->nullable()->comment();
            $table->string('descrip')->nullable()->comment();
            $table->tinyInteger('ifthumb', false)->nullable(0)->comment();
            $table->integer('uid')->nullable()->comment('UID');
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->string('module')->nullable()->comment();
            $table->integer('module_id')->nullable()->comment('appid');
            $table->string('disk')->nullable()->comment();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attachments');
    }
}
