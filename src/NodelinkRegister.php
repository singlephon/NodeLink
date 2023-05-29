<?php

namespace Singlephon\Nodelink;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Singlephon\Nodelink\Service\Intentions\Security;

class NodelinkRegister
{
    use Security;
    public function init(Request $request)
    {
        $data = $request->validate([
            'registerKey' => [
                'required',
                'string',
                'min:64',
                'max:64',
           ]
        ]);
        $validKey = $this->assertChecksum(URL::to(''), env('NODELINK_SERVICE_APP_KEY'), $data['registerKey']);
        if (!$validKey) return response()->json([], 422);
        return response()->json([
            'name' => env('NODELINK_SERVICE_APP_NAME'),
            'version' => env('NODELINK_SERVICE_APP_VERSION'),
            'test_version' => env('NODELINK_SERVICE_APP_TEST_VERSION', 0)
        ]);
    }
}
