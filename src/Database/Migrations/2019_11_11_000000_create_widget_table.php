<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('widget', function (Blueprint $table)
        {
            $table->string('name', 30)->default('')->comment(trans('thinkwinds::hook.name'));
            $table->string('module', 30)->default('manage')->comment(trans('thinkwinds::hook.module'));
            $table->text('description', 255)->comment(trans('thinkwinds::hook.description'));
            $table->tinyInteger('issystem', false)->default(0)->comment(trans('thinkwinds::hook.issystem'));
            $table->integer('times')->nullable()->comment(trans('thinkwinds::manage.times'));
            $table->text('document', 255)->comment(trans('thinkwinds::hook.document'));
            $table->primary('name');
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
        Schema::drop('widget');
    }
}
