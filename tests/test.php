<?php
include "../vendor/autoload.php";

require "./TestRequester.php";

class TestRequest
{
    public static function main()
    {
        $username = "冉平";
        $pwd      = "1111111";
        $exp      = 86400;

        //不继承
        $request = new \Epet\MicroRequest\BaseRequest();
        $request->setConsulHttpAddress('192.168.10.222:8500');
        $request->setServiceName('php-server-common');
        $request->setServiceVersion('v1');
        $request->setServicePath('/auth/issue');
        $request->setRequestParam('username', $username);
        $request->setRequestParam('pwd', $pwd);
        $request->setRequestParam('exp', $exp);
        // 继承

//        $request = new TestRequester();
//        $request->setConsulHttpAddress('192.168.10.222:8500');
//        $request->setServiceName('php-server-common');
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