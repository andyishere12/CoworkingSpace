    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
    public function up(): void
    {
        Schema::create('data_members', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('aktivitas');
            $table->string('institusi');
            $table->string('type');
            $table->string('status');   // kalau mau langsung dimasukkan
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('data_members');
        }
    };