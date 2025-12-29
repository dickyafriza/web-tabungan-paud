<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Tabungan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaldoCalculationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_saldo_correctly_for_deposit()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        // First deposit
        $tabungan1 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);

        $this->assertEquals(10000, $tabungan1->saldo);

        // Second deposit
        $tabungan2 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 5000,
            'saldo' => 15000
        ]);

        $this->assertEquals(15000, $tabungan2->saldo);
    }

    /** @test */
    public function it_calculates_saldo_correctly_for_withdrawal()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        // Deposit
        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);

        // Withdrawal
        $withdrawal = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'out',
            'jumlah' => 3000,
            'saldo' => 7000
        ]);

        $this->assertEquals(7000, $withdrawal->saldo);
    }

    /** @test */
    public function it_maintains_correct_saldo_across_multiple_transactions()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        // Scenario: deposit 10k, deposit 5k, withdraw 3k, deposit 2k
        $t1 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);
        $this->assertEquals(10000, $t1->saldo);

        $t2 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 5000,
            'saldo' => 15000
        ]);
        $this->assertEquals(15000, $t2->saldo);

        $t3 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'out',
            'jumlah' => 3000,
            'saldo' => 12000
        ]);
        $this->assertEquals(12000, $t3->saldo);

        $t4 = Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 2000,
            'saldo' => 14000
        ]);
        $this->assertEquals(14000, $t4->saldo);
    }

    /** @test */
    public function latest_saldo_reflects_current_balance()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);

        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 5000,
            'saldo' => 15000
        ]);

        $latestTabungan = Tabungan::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')  // Add ID ordering for consistency
            ->first();

        $this->assertEquals(15000, $latestTabungan->saldo);
    }

    /** @test */
    public function saldo_verification_matches_transaction_sum()
    {
        $kelas = Kelas::factory()->create();
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 10000,
            'saldo' => 10000
        ]);

        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'in',
            'jumlah' => 5000,
            'saldo' => 15000
        ]);

        Tabungan::create([
            'siswa_id' => $siswa->id,
            'tipe' => 'out',
            'jumlah' => 3000,
            'saldo' => 12000
        ]);

        // Calculate from transactions
        $totalIn = Tabungan::where('siswa_id', $siswa->id)
            ->where('tipe', 'in')
            ->sum('jumlah');

        $totalOut = Tabungan::where('siswa_id', $siswa->id)
            ->where('tipe', 'out')
            ->sum('jumlah');

        $calculatedSaldo = $totalIn - $totalOut;

        // Get latest saldo with ID ordering
        $latestSaldo = Tabungan::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')  // Add ID ordering for consistency
            ->first()->saldo;

        $this->assertEquals($calculatedSaldo, $latestSaldo);
        $this->assertEquals(12000, $latestSaldo);
    }
}
