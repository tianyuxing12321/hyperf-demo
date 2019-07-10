<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Model\User;

class IndexController extends Controller
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return $this->response->success([
            'user' => $user,
            'method' => $method,
            'message' => 'Hello Hyperf.',
        ]);
    }

    public function handle()
    {
        $user = User::findFromCache(1);

        return $this->response->success($user->toArray());
    }

    public function handle2()
    {
        $time = microtime(true);

        $user = User::query()->find(1);

        $redis = di()->get(\Redis::class);

        $redis->hMSet(uniqid(), $user->toArray());

        return $this->response->success(microtime(true) - $time);
    }
}
