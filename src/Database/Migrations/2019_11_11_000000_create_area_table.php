<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('area', function (Blueprint $table) 
        {
            $table->increments('areaid')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->string('joinname', 50)->default('')->comment();
            $table->string('parentid', 50)->default('')->comment();
            $table->string('vieworder', 50)->default('')->comment();
            $table->string('zip', 50)->default('')->comment();
            $table->string('initials', 50)->default('')->comment();
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
        Schema::drop('area');
    }
}
