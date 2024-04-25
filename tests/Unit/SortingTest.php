<?php

namespace Tests\Unit;

use App\Helpers\Sorting;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_sort_and_calculate()
    {

        $saldoawal = 100000;
        $mutasi = [
            (object)["tanggal" => "2021-10-01", "masuk" => 200000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-03", "masuk" => 300000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-05", "masuk" => 150000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-02", "masuk" => 0, "keluar" => 100000, "saldo" => 0],
            (object)["tanggal" => "2021-10-04", "masuk" => 0, "keluar" => 150000, "saldo" => 0],
            (object)["tanggal" => "2021-10-06", "masuk" => 0, "keluar" => 50000, "saldo" => 0]
        ];

        Sorting::SortAndCalculateSaldo($saldoawal, $mutasi);

        //check first date
        $this->assertEquals(300000, $mutasi[0]->saldo);

        //check last date
        $this->assertEquals(450000, $mutasi[5]->saldo);
    }

    public function test_sort_and_calculate_stok()
    {

        $saldoAwalStok = 0;
        $saldoAwalStokRp = 0;
        $kartuStok = array(
            (object)["tanggal" => "2021-10-01", "masuk" => 10, "keluar" => 0, "saldoQty" => 0, "masukRp" => 10000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-03", "masuk" => 45, "keluar" => 0, "saldoQty" => 0, "masukRp" => 36000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-05", "masuk" => 40, "keluar" => 0, "saldoQty" => 0, "masukRp" => 35000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-02", "masuk" => 0, "keluar" => 5, "saldoQty" => 0, "masukRp" => 0, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-04", "masuk" => 0, "keluar" => 40, "saldoQty" => 0, "masukRp" => 0, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-06", "masuk" => 0, "keluar" => 35, "saldoQty" => 0, "masukRp" => 0, "keluarRp" => 0, "saldoRp" => 0]
        );

        $mutasi = Sorting::sortAndCalculateStok($saldoAwalStok, $saldoAwalStokRp, $kartuStok);

        //check first date
        $this->assertEquals(10000, $mutasi[0]->saldoRp);

        //check last date
        $this->assertEquals(12960, $mutasi[5]->saldoRp);
    }


}
