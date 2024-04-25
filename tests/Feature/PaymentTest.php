<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_net_sales()
    {
        $request = [
            'total' => '35000',
            'persen_pajak' => '10'
        ];

        $this->json('POST', 'api/payment/net_sales', $request, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'S',
                'data' => [
                    "net_sales" => 35000,
                    "rupiah_pajak" => 3500
                ]
            ]);

        // print_r($result->json());
    }

    public function test_net_sales_with_discounts()
    {
        $request = [
            'discounts' => [
                [
                    'diskon' => '20'
                ],
                [
                    'diskon' => '10'
                ]
            ],
            'total_sebelum_diskon' => 100000
        ];

        $this->json('POST', 'api/payment/discount', $request, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'S',
                'data' => [
                    "total_diskon" => 30000,
                    "total_harga_setelah_diskon" => 70000
                ]
            ]);
    }

    public function test_markup()
    {
        $request = [
            'harga_sebelum_markup' => 10000,
            'markup_persen' => 10,
            'share_persen' => 20
        ];

        $this->json('POST', 'api/payment/share_revenue', $request, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'S',
                'data' => [
                    "net_untuk_resto" => 8800,
                    "share_untuk_ojol" => 2200
                ]
            ]);
    }
}

