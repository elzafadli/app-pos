<?php

namespace App\Helpers;

class Sorting
{


    public static function SortAndCalculateSaldo($saldoawal, $mutasi)
    {
        // Sort the array by tanggal in ascending order
        usort($mutasi, function ($a, $b) {
            return strtotime($a->tanggal) - strtotime($b->tanggal);
        });

        // Calculate the saldo for each index
        $saldo = $saldoawal;
        foreach ($mutasi as $index => $data) {
            $mutasi[$index]->saldo = $saldo + $data->masuk - $data->keluar;
            $saldo = $mutasi[$index]->saldo;
        }

        return $mutasi;
    }

    public static function SortAndCalculateStok($saldoAwalStok, $saldoAwalStokRp, $kartuStok) {
        // Sort the array by tanggal in ascending order
        usort($kartuStok, function ($a, $b) {
            return strtotime($a->tanggal) - strtotime($b->tanggal);
        });

        // Calculate the akumulasi keluarRp, saldoQty, and saldoRp
        $saldoQty = $saldoAwalStok;
        $saldoRp = $saldoAwalStokRp;
        foreach ($kartuStok as $index => $data) {
            if ($saldoQty != 0) {
                $kartuStok[$index]->keluarRp = $saldoRp / $saldoQty * $data->keluar;
            } else {
                $kartuStok[$index]->keluarRp = 0;
            }

            $kartuStok[$index]->saldoQty = $saldoQty + $data->masuk - $data->keluar;
            $kartuStok[$index]->saldoRp = $saldoRp + $data->masukRp - $kartuStok[$index]->keluarRp;
            
            $saldoQty = $kartuStok[$index]->saldoQty;
            $saldoRp = $kartuStok[$index]->saldoRp;
        }

        return $kartuStok;
    }
}
