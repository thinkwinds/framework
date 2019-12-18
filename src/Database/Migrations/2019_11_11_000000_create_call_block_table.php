<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('call_block', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->string('type')->nullable()->comment();
            $table->string('module')->nullable()->comment();
            $table->tinyInteger('isopen', false)->default(0)->nullable()->comment();
            $table->text('configures')->comment();
            $table->text('upsetting')->comment();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('call_block');
    }
}
