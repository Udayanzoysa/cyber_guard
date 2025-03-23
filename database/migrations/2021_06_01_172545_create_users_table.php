<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username','20');
            $table->string('password');
            $table->string('gender')->nullable();
            $table->enum('district', [
                'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo', 
                'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara', 
                'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar', 
                'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya', 
                'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
            ])->nullable(); // Optional: Use nullable() if it's not mandatory
            
            $table->enum('university', [
                'University of Colombo', 'University of Peradeniya', 'University of Moratuwa',
                'University of Ruhuna', 'Eastern University, Sri Lanka', 'Sabaragamuwa University of Sri Lanka',
                'University of Sri Jayewardenepura', 'Wayamba University of Sri Lanka',
                'University of the Visual and Performing Arts', 'The Open University of Sri Lanka',
                'University of Vavuniya', 'Rajarata University of Sri Lanka',
                'South Eastern University of Sri Lanka', 'Gampaha Wickramarachchi University of Indigenous Medicine'
            ])->nullable(); // Optional: Use nullable() if it's not mandatory
            $table->string('filed_of_study')->nullable();
            $table->string('year_of_study')->nullable();
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
        Schema::dropIfExists('users');
    }
}
