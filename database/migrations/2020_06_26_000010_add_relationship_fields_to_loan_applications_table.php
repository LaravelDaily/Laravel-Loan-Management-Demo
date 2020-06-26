<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLoanApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_1721035')->references('id')->on('statuses');
            $table->unsignedInteger('analyst_id')->nullable();
            $table->foreign('analyst_id', 'analyst_fk_1721036')->references('id')->on('users');
            $table->unsignedInteger('cfo_id')->nullable();
            $table->foreign('cfo_id', 'cfo_fk_1721037')->references('id')->on('users');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_1721041')->references('id')->on('users');
        });
    }
}
