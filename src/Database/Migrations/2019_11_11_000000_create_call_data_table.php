<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('call_data', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->integer('block_id')->nullable()->comment();
            $table->integer('start_times')->nullable()->comment(;
            $table->integer('end_times')->nullable()->comment();
            $table->integer('sort')->nullable()->comment();
            $table->integer('type')->nullable()->comment();
            $table->tinyInteger('is_edit', false)->default(0)->nullable()->comment();
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
        //
        Schema::dropIfExists('call_data');
    }
}
