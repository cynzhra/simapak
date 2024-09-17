use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 255)->unique();
            $table->string('nama');
            $table->integer('umur');
            $table->enum('jk', ['p', 'l']);
            $table->string('jabatan');
            $table->enum('pendidikan', ['sd', 'smp', 'sma', 'd3', 'd4', 's1', 's2', 's3']);
            $table->enum('unit_kerja',['Sekretaris', 'Perekonomian dan Sumber Daya Alam', 'Infrastruktur dan Kewilayahan', 'Pemerintahan dan Pembangunan Manusia', 'Perencanaan, Pengendalian dan Evaluasi Pembangunan Daerah']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan');  // Pastikan hanya ada satu method down
    }
}
