<?php
include "../vendor/autoload.php";

require "./TestRequester.php";

class TestRequest
{
    public static function main()
    {
        $username = "冉平";
        $pwd      = "111111";
        $exp      = 86400;

        //不继承
        $request = new \Epet\MicroRequest\BaseRequest();
        $request->setServiceVersion('v1');
        $request->setServicePath('/auth/issue');
        $request->setRequestParam('username', $username);
        $request->setRequestParam('pwd', $pwd);
        $request->setRequestParam('exp', $exp);
        // 继承
//        $request = new TestR  equester();
        $request->setServiceHost('http://192.168.56.3');
        $request->setServicePort('9502');
//        $soaManager = null; //配置soa
//        $request->setSoaManager($soaManager);
//        $request->setUsername($username);
//        $request->setPwd($pwd);
//        $request->setExp($exp);

        $response = $request->send()->getResponse();
        if ($response->getStatusCode() != 200) {
            print_r($response->getStatusCode());
        }

        print_r($response->getData());
    }
}


TestRequest::main();