<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_logs', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('type', 30)->default('')->comment(tw_lang('thinkwinds::public.type'));
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->integer('uid')->nullable()->comment('UID');
            $table->string('note', 255)->default('')->comment(tw_lang('thinkwinds::public.note'));
            $table->string('code', 255)->default('')->comment(tw_lang('thinkwinds::public.code'));
            $table->string('sendnum', 255)->default('')->comment(tw_lang('thinkwinds::public.num'));
            $table->text('content', 255)->comment(tw_lang('thinkwinds::public.content'));
            $table->text('mobile', 255)->comment(tw_lang('thinkwinds::public.mobile'));
            $table->tinyInteger('status', false)->default(1)->comment(tw_lang('thinkwinds::public.status'));
            $table->string('rtype', 255)->default('')->comment();
            $table->string('requestid', 255)->default('')->comment();
            $table->integer('jstimes')->nullable()->comment();
            $table->integer('stimes')->nullable()->comment();
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
        Schema::drop('sms_logs');
    }
}
