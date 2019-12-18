<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_operation_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('uid')->nullable()->comment('UID');
            $table->string('username')->nullable()->comment(tw_lang('thinkwinds::public.username'));
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
            $table->tinyInteger('status', false)->default(0)->nullable()->comment(tw_lang('thinkwinds::public.review.status'));
            $table->string('suid')->nullable()->comment(tw_lang('thinkwinds::public.review.uid'));
            $table->string('susername')->nullable()->comment(tw_lang('thinkwinds::public.review.username'));
            $table->integer('stimes')->nullable()->comment(tw_lang('thinkwinds::public.review.times'));
            $table->ipAddress('ip')->nullable()->comment('IP');
            $table->string('port', 10)->nullable()->comment('IP'.tw_lang('thinkwinds::public.port'));
            $table->string('platform')->nullable()->comment(tw_lang('thinkwinds::public.operating.system'));
            $table->string('browser')->nullable()->comment(tw_lang('thinkwinds::public.browser'));
            $table->text('olddata')->nullable()->comment(tw_lang('thinkwinds::public.olddata'));
            $table->text('newdata')->nullable()->comment(tw_lang('thinkwinds::public.newdata'));
            $table->text('change')->nullable()->comment(tw_lang('thinkwinds::public.change'));
            $table->text('remark')->nullable()->comment(tw_lang('thinkwinds::public.remark'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manage_operation_log');
    }
}
