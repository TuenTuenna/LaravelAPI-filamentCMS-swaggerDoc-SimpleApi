<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



/**
 * @OA\Info(
 *      version="3.3.6",
 *      title="빡코딩 블로그",
 *      description="빡코딩 블로그 API 문서",
 *      @OA\Contact(
 *          email="dev_jeongdaeri@email.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_TEST_HOST,
 *      description="테스트 서버"
 *  )
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_REAL_HOST,
 *      description="실 서버"
 *  )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
