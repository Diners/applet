<?php

namespace Common\Lib\Alidayu;

include('TopSdk.php');

use TopClient;
use AlibabaAliqinFcSmsNumSendRequest;

class SendMsg {
//需要更改的数据
    public function send(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_12325316', 
            $smsFreeSignName = '卜二科技')
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }
	  public function send_message(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_38050075', 
            $smsFreeSignName = '加2') 
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }
	// 免单
	public function success_message(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_60990091', 
            $smsFreeSignName = '加2') 
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }
	public function error_message(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_52510135 ', 
            $smsFreeSignName = '加2') 
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }
	public function free_message(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_52380216 ', 
            $smsFreeSignName = '加2') 
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }
	public function sale_message(
            $recNum = '', 
            $smsParam = '',
            $smsTemplateCode = 'SMS_62495092', 
            $smsFreeSignName = '加2') 
                {
        $c = new TopClient;
        $c->format = "json";
        $c->appkey = '23410021';
        $c->secretKey = '410797f1f07a86dab652933d1a79597b';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("返回数据测试");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam($smsParam);
        $req->setRecNum($recNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        $resp = $c->execute($req);
        return $resp;
    }

}
