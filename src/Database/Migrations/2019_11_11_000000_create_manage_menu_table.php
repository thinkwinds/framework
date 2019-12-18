<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manage_menu', function (Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('name', 30)->default('')->comment(tw_lang('thinkwinds::public.name'));
            $table->string('ename', 30)->default('')->comment(tw_lang('thinkwinds::public.ename'));
            $table->string('icon', 50)->default('')->comment(tw_lang('thinkwinds::public.icon'));
            $table->string('url')->default('')->comment('url');
            $table->tinyInteger('level', false)->default(0)->comment(tw_lang('thinkwinds::public.level'));
            $table->string('parent', 30)->default('root')->comment(tw_lang('thinkwinds::public.parent'));
            $table->string('parents', 30)->default('')->comment(tw_lang('thinkwinds::public.parents'));
            $table->string('module', 30)->default('manage')->comment(tw_lang('thinkwinds::public.module'));
            // $table->timestamps();
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
        Schema::drop('manage_menu');
    }
}
