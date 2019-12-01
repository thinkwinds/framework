<?php
/**
 * @author huasituo <info@huasituo.com>
 * @copyright ©2016-2100 huasituo.com
 * @license http://www.huasituo.com
 */
namespace Thinkwinds\Framework\Repositories;

use Thinkwinds\Framework\Contracts\Repository as RepositoryContract;

use Illuminate\Config\Repository as Config;

class Repository implements RepositoryContract
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Constructor method.
     *
     * @param \Illuminate\Config\Repository     $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function version()
    {
        return $this->config->get('thinkwinds.version');
    }
}
