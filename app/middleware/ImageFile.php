<?php

declare(strict_types=1);

namespace app\middleware;

use app\core\Result;
use think\Request;
use think\Response;

class ImageFile
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @param integer $size 文件体积
     * @return Response
     */
    public function handle(Request $request, \Closure $next, int $size = 1024 * 1024 * 50): Response
    {

        $image = $request->file('image');
        $mine = $image->getOriginalMime();

        if (!stristr($mine, 'image/')) {
            return (new Result(Result::CODE_ERROR_PARAM, '文件格式错误，仅接受图片文件'))->toJson();
        }

        if ($image->getSize() > $size) {
            return (new Result(Result::CODE_ERROR_PARAM, '文件体积过大，仅接受体积为' . round($size / 1048576, 1) . 'MB以内的文件'))->toJson();
        }

        return $next($request);
    }
}
