<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    //
    public function transfer(Request $request)
    {
        $request->out_biz_no;
        $request->trans_amount;
        $request->payee_info;
        $request->sign;
        $secret = env("PAY_SECRET");
        return $request->out_biz_no . $request->nonce . $request->trans_amount . $request->payee_info["identity"] . $secret;
        if ($request->sign == hash("sha256", $request->out_biz_no . $request->nonce . $request->trans_amount . $request->payee_info["identity"] . $secret)) {

            return response("wrong signature", 500);
        } else {
            return 123;
        }

        // $result = Pay::alipay()->transfer([
        //     'out_biz_no' => time(),
        //     'trans_amount' => '1.00',
        //     'product_code' => 'TRANS_ACCOUNT_NO_PWD',
        //     'biz_scene' => 'DIRECT_TRANSFER',
        //     'payee_info' => [
        //         'identity' => '15521224344',
        //         'identity_type' => 'ALIPAY_LOGON_ID',
        //         'name' => '张智铭'
        //     ],
        // ]);
        // return $result;
    }

    public function sign(Request $request)
    {
        $request->out_biz_no;
        $request->nonce;
        $request->trans_amount;
        $request->payee_info;
        $secret = env("PAY_SECRET");
        return hash("sha256", $request->out_biz_no . $request->nonce . $request->trans_amount . $request->payee_info["identity"] . $secret);
        // $result = Pay::alipay()->transfer([
        //     'out_biz_no' => time(),
        //     'trans_amount' => '1.00',
        //     'product_code' => 'TRANS_ACCOUNT_NO_PWD',
        //     'biz_scene' => 'DIRECT_TRANSFER',
        //     'payee_info' => [
        //         'identity' => '15521224344',
        //         'identity_type' => 'ALIPAY_LOGON_ID',
        //         'name' => '张智铭'
        //     ],
        // ]);
        // return $result;
    }
}
