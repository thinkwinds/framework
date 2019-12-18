<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('module')->nullable()->comment();
            $table->string('relatedid')->nullable()->comment();
            $table->string('relatedtable')->nullable()->comment();
            $table->string('name')->nullable()->comment(tw_lang('thinkwinds::public.name'));
            $table->string('fieldname')->nullable()->comment();
            $table->string('fieldtype')->nullable()->comment();
            $table->tinyInteger('ismain', false)->nullable(0)->comment();
            $table->tinyInteger('ismshow', false)->nullable(0)->comment();
            $table->tinyInteger('ismember', false)->nullable(0)->comment();
            $table->tinyInteger('issearch', false)->nullable(0)->comment();
            $table->tinyInteger('vieworder', false)->nullable(0)->comment();
            $table->tinyInteger('disabled', false)->nullable(0)->comment();
            $table->text('setting')->nullable()->comment();
            $table->integer('times')->nullable()->comment(tw_lang('thinkwinds::public.times'));
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
        Schema::drop('fields');
    }
}
