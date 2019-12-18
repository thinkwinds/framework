<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Repositories;

use Illuminate\Config\Repository as Config;
use Thinkwinds\Framework\Contracts\Repository as RepositoryContract;

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
