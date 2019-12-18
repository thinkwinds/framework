<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('api', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->integer('edittimes')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->tinyInteger('status', false)->default(0)->nullable()->comment(tw_lang('thinkwinds::public.status'));
            $table->string('appid')->nullable()->comment();
            $table->string('secret')->nullable()->comment();
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
        Schema::dropIfExists('api');
    }
}
