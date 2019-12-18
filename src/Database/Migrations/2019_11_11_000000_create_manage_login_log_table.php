<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageLoginLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manage_login_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('uid')->nullable()->comment('UID');
            $table->string('username')->nullable()->comment(tw_lang('thinkwinds::public.username'));
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->text('remark')->nullable()->comment(tw_lang('thinkwinds::public.remark'));
            $table->ipAddress('ip')->nullable()->comment('IP');
            $table->string('port', 10)->nullable()->comment('IP'.tw_lang('thinkwinds::public.port'));
            $table->string('platform')->nullable()->comment(tw_lang('thinkwinds::public.username'));
            $table->string('browser')->nullable()->comment(tw_lang('thinkwinds::public.username'));
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
        Schema::drop('manage_login_log');
    }
}
