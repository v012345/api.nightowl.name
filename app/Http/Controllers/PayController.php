<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    //
    public function transfer(Request $request)
    {
        $result = Pay::alipay()->transfer([
            'out_biz_no' => "85574755447554",
            'trans_amount' => '1.00',
            'product_code' => 'TRANS_ACCOUNT_NO_PWD',
            'biz_scene' => 'DIRECT_TRANSFER',
            'payee_info' => [
                'identity' => '15521224344',
                'identity_type' => 'ALIPAY_LOGON_ID',
                'name' => '张智铭'
            ],
        ]);
        return $result;
    }
}
