<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('modules', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->text('description')->comment();
            $table->string('slug', 50)->default('')->comment();
            $table->string('version', 50)->comment();
            $table->string('enabled', 10)->comment();
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
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
        Schema::drop('modules');
    }
}
