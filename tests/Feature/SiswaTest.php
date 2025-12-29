<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\Kelas;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiswaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create authenticated user for testing
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function it_can_list_siswa()
    {
        $kelas = Kelas::factory()->create(['nama' => 'TK A']);
        Siswa::factory()->count(5)->create(['kelas_id' => $kelas->id]);

        $response = $this->actingAs($this->user)->get('/siswa');

        $response->assertStatus(200);
        $response->assertViewHas('siswa');
    }

    /** @test */
    public function it_can_create_siswa()
    {
        $kelas = Kelas::factory()->create();

        $siswaData = [
            'kelas_id' => $kelas->id,
            'nama' => 'Ahmad Test',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2018-05-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Test No. 123',
            'nama_wali' => 'Budi Test',
            'telp_wali' => '081234567890',
            'pekerjaan_wali' => 'Wiraswasta',
            'is_yatim' => 0
        ];

        $response = $this->actingAs($this->user)
            ->post('/tambah-siswa', $siswaData);

        $response->assertRedirect('/siswa');
        $this->assertDatabaseHas('siswa', [
            'nama' => 'Ahmad Test',
            'kelas_id' => $kelas->id
        ]);
    }

    /** @test */
    public function it_can_filter_siswa_by_kelas()
    {
        $kelas1 = Kelas::factory()->create(['nama' => 'TK A']);
        $kelas2 = Kelas::factory()->create(['nama' => 'TK B']);
        
        Siswa::factory()->count(3)->create(['kelas_id' => $kelas1->id]);
        Siswa::factory()->count(2)->create(['kelas_id' => $kelas2->id]);

        $response = $this->actingAs($this->user)
            ->get('/siswa?kelas_id=' . $kelas1->id);

        $response->assertStatus(200);
        // Should have filtered results
    }

    /** @test */
    public function it_can_search_siswa()
    {
        $kelas = Kelas::factory()->create();
        Siswa::factory()->create([
            'kelas_id' => $kelas->id,
            'nama' => 'Ahmad Zaki'
        ]);
        Siswa::factory()->create([
            'kelas_id' => $kelas->id,
            'nama' => 'Siti Nurhaliza'
        ]);

        $response = $this->actingAs($this->user)
            ->get('/siswa?search=Ahmad');

        $response->assertStatus(200);
        // Should return search results
    }

    /** @test */
    public function it_can_update_siswa()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create([
            'kelas_id' => $kelas->id,
            'nama' => 'Original Name'
        ]);

        $updateData = [
            'kelas_id' => $kelas->id,
            'nama' => 'Updated Name',
            'jenis_kelamin' => 'L'
        ];

        $response = $this->actingAs($this->user)
            ->post("/siswa/{$siswa->id}/ubah", $updateData);

        $response->assertRedirect('/siswa');
        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
            'nama' => 'Updated Name'
        ]);
    }

    /** @test */
    public function it_can_soft_delete_siswa()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        $response = $this->actingAs($this->user)
            ->post("/siswa/{$siswa->id}/hapus");

        $response->assertRedirect('/siswa');
        $this->assertSoftDeleted('siswa', ['id' => $siswa->id]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_siswa()
    {
        $response = $this->actingAs($this->user)
            ->post('/tambah-siswa', []);

        $response->assertSessionHasErrors(['kelas_id', 'nama']);
    }
}
