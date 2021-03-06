<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    //
    public function transfer(Request $request)
    {
        return Pay::alipay()->transfer([
            'out_biz_no' => $request->out_biz_no,
            'trans_amount' => $request->trans_amount,
            'product_code' => 'TRANS_ACCOUNT_NO_PWD',
            'biz_scene' => 'DIRECT_TRANSFER',
            'payee_info' => [
                'identity' => $request->payee_info["identity"],
                'identity_type' => 'ALIPAY_LOGON_ID',
                'name' => $request->payee_info["name"]
            ],
        ]);
    }
}
