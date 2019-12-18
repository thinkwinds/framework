<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetInjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('widget_inject', function (Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('widget_name', 50)->default('')->comment(trans('thinkwinds::hook.name'));
            $table->string('alias', 100)->default('')->comment(trans('thinkwinds::hook.alias'));
            $table->string('files', 150)->default('')->comment(trans('thinkwinds::hook.files'));
            $table->string('class', 50)->default('root')->comment(trans('thinkwinds::hook.class'));
            $table->string('fun', 50)->default('root')->comment(trans('thinkwinds::hook.fun'));
            $table->text('description', 255)->comment(trans('thinkwinds::hook.description'));
            $table->tinyInteger('issystem', false)->default(0)->comment(trans('thinkwinds::hook.issystem'));
            $table->integer('times')->nullable()->comment(trans('thinkwinds::public.times'));
            $table->unique(['widget_name', 'alias']);
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
        Schema::drop('widget_inject');
    }
}
