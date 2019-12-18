<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('module', 30)->default('default')->comment(tw_lang('thinkwinds::public.module'));
            $table->string('table', 30)->comment(tw_lang('thinkwinds::public.table'));
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->integer('relatedid')->nullable()->comment();
            $table->text('setting')->comment();
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('form');
    }
}
