<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $response = array(
        "status" => "S",
        "data" => null
    );

    public function CalculateTotal(Request $request)
    {
        $response = $this->response;

        $request->validate([
            'total' => 'required',
            'persen_pajak' => 'required'
        ]);

        $total = $request->input('total');
        $persen_pajak = $request->input('persen_pajak');

        $net_sales = $total;
        $rupiah_pajak = $total * ($persen_pajak / 100);

        $response['data'] = [
            'net_sales' => $net_sales,
            'rupiah_pajak' => $rupiah_pajak
        ];

        return $response;
    }

    public function CalculateDiscount(Request $request)
    {
        $response = $this->response;

        $request->validate([
            'discounts' => 'required|array',
            'total_sebelum_diskon' => 'required|numeric'
        ]);

        $discounts = $request->input('discounts');
        $total_sebelum_diskon = $request->input('total_sebelum_diskon');

        $total_diskon = 0;
        foreach ($discounts as $discount) {
            $diskon = $discount['diskon'];
            $total_diskon += $total_sebelum_diskon * ($diskon / 100);
        }

        $total_harga_setelah_diskon = $total_sebelum_diskon - $total_diskon;

        $response['data'] = [
            'total_diskon' => $total_diskon,
            'total_harga_setelah_diskon' => $total_harga_setelah_diskon
        ];

        return $response;
    }

    public function CalculateShareRevenue(Request $request)
    {
        $response = $this->response;

        $request->validate([
            'harga_sebelum_markup' => 'required',
            'markup_persen' => 'required',
            'share_persen' => 'required'
        ]);

        $harga_sebelum_markup = $request->input('harga_sebelum_markup');
        $markup_persen = $request->input('markup_persen');
        $share_persen = $request->input('share_persen');

        $harga_setelah_markup = $harga_sebelum_markup * (1 + ($markup_persen / 100));

        $net_untuk_resto = $harga_setelah_markup * (1 - ($share_persen / 100));
        $share_untuk_ojol = $harga_setelah_markup * ($share_persen / 100);

        $response['data'] = [
            'net_untuk_resto' => $net_untuk_resto,
            'share_untuk_ojol' => $share_untuk_ojol
        ];

        return $response;
    }
}



