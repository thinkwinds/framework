<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_uri', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->string('ename')->nullable()->comment(tw_lang('thinkwinds::public.ename'));
            $table->string('uri')->nullable()->comment('URI'.tw_lang('thinkwinds::public.name'));
            $table->string('parent')->default('')->comment(tw_lang('thinkwinds::public.parent'));
            $table->string('module', 30)->default('manage')->comment(tw_lang('thinkwinds::public.module'));
            $table->text('remark')->nullable()->comment(tw_lang('thinkwinds::public.remark'));
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_uri');
    }
}
