<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageUserTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_user', function (Blueprint $table) {
            $table->increments('uid')->comment('ID');
            $table->string('username')->nullable()->comment(tw_lang('thinkwinds::public.username'));
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.realname'));
            $table->string('email')->nullable()->comment(tw_lang('thinkwinds::public.email'));
            $table->string('password')->nullable()->comment(tw_lang('thinkwinds::public.password'));
            $table->string('salt', 10)->nullable()->comment(tw_lang('thinkwinds::public.salt'));
            $table->tinyInteger('status', false)->nullable(0)->comment(tw_lang('thinkwinds::public.user.status'));
            $table->string('avatar')->nullable()->comment(tw_lang('thinkwinds::public.avatar'));
            $table->string('mobile', 20)->nullable()->comment(tw_lang('thinkwinds::public.mobile'));
            $table->string('qq', 20)->nullable()->comment('QQ');
            $table->string('weixin', 20)->nullable()->comment(tw_lang('thinkwinds::public.weixin'));
            $table->string('gid', 10)->nullable(99)->comment(tw_lang('thinkwinds::public.manage.user.gid'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manage_user');
    }
}
