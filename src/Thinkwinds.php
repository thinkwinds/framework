<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework;

use Illuminate\Foundation\Application;
use Thinkwinds\Framework\Contracts\Repository;

class Thinkwinds
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Create a new Modules instance.
     *
     * @param Application         $app
     * @param Repository $repository
     */
    public function __construct(Application $app, Repository $repository)
    {
        $this->app        = $app;
        $this->repository = $repository;
    }

    /**
     * Oh sweet sweet magical method.
     *
     * @param  string  $method
     * @param  mixed  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->repository, $method], $arguments);
    }
}
