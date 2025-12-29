<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Tabungan;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TabunganTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function it_can_list_tabungan()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);
        Tabungan::factory()->count(5)->create(['siswa_id' => $siswa->id]);

        $response = $this->actingAs($this->user)->get('/tabungan');

        $response->assertStatus(200);
        $response->assertViewHas('tabungan');
    }

    /** @test */
    public function it_can_filter_tabungan_by_siswa()
    {
        $kelas = Kelas::factory()->create();
        $siswa1 = Siswa::factory()->create(['kelas_id' => $kelas->id]);
        $siswa2 = Siswa::factory()->create(['kelas_id' => $kelas->id]);
        
        Tabungan::factory()->count(3)->create(['siswa_id' => $siswa1->id]);
        Tabungan::factory()->count(2)->create(['siswa_id' => $siswa2->id]);

        $response = $this->actingAs($this->user)
            ->get('/tabungan?siswa_id=' . $siswa1->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_filter_tabungan_by_type()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);
        
        Tabungan::factory()->create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);
        Tabungan::factory()->create([
            'siswa_id' => $siswa->id,
            'tipe' => 'out',
            'jumlah' => 5000,
            'saldo' => 5000
        ]);

        $response = $this->actingAs($this->user)
            ->get('/tabungan?tipe=in');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_tabungan()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);
        $tabungan = Tabungan::factory()->create(['siswa_id' => $siswa->id]);

        $response = $this->actingAs($this->user)
            ->delete("/tabungan/{$tabungan->id}/hapus");

        $response->assertRedirect('/tabungan');
        $this->assertSoftDeleted('tabungan', ['id' => $tabungan->id]);
    }
}
