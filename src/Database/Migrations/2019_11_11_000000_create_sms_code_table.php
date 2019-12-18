<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_code', function (Blueprint $table) 
        {
            $table->string('mobile', 30)->default('')->comment(tw_lang('thinkwinds::public.mobile'));
            $table->string('type', 30)->default('')->comment(tw_lang('thinkwinds::public.type'));
            $table->string('code', 30)->default('')->comment(tw_lang('thinkwinds::public.code'));
            $table->string('number', 30)->default('')->comment(tw_lang('thinkwinds::public.type'));
            $table->integer('expired_time')->nullable()->comment();
            $table->integer('create_time')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->unique(['mobile','type']);
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
        Schema::drop('sms_code');
    }
}
