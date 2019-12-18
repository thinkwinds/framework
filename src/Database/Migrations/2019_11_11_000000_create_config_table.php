<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('config', function (Blueprint $table) 
        {
            $table->increments('id')->comment('ID');
            $table->string('name', 30)->default('')->comment(tw_lang('thinkwinds::public.name'));
            $table->string('namespace', 30)->default('')->comment(tw_lang('thinkwinds::public.namespace'));
            $table->text('value', 255)->comment(tw_lang('thinkwinds::public.cvalue'));
            $table->enum('vtype', ['string','array','object'])->default('string')->nullable();
            $table->text('desc', 255)->comment(tw_lang('thinkwinds::public.desc'));
            $table->tinyInteger('issystem', false)->default(0)->comment(tw_lang('thinkwinds::public.issystem'));
            $table->string('module', 30)->default('')->comment(tw_lang('thinkwinds::public.module'));
            $table->unique(['name','namespace']);
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
        Schema::drop('config');
    }
}
