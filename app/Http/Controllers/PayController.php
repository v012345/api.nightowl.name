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
            'out_biz_no' => time(),
            'trans_amount' => '0.01',
            'product_code' => 'TRANS_ACCOUNT_NO_PWD',
            'biz_scene' => 'DIRECT_TRANSFER',
            'payee_info' => [
                'identity' => '15521224344',
                'identity_type' => 'ALIPAY_LOGON_ID',
                'name' => '沙箱环境'
            ],
        ]);
        return $result;
    }
}
