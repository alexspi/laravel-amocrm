<?php

/*
 * This file is part of Laravel AmoCrm.
 *
 * (c) dotzero <mail@dotzero.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dotzero\LaravelAmoCrm;

use AmoCRM\Client;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the AmoCrm manager class.
 *
 * @package Dotzero\LaravelAmoCrm
 * @author dotzero <mail@dotzero.ru>
 * @link http://www.dotzero.ru/
 * @link https://github.com/dotzero/laravel-amocrm
 * @property \AmoCRM\Models\Account $account
 * @property \AmoCRM\Models\Company $company
 * @property \AmoCRM\Models\Contact $contact
 * @property \AmoCRM\Models\Lead $lead
 * @property \AmoCRM\Models\Note $note
 * @property \AmoCRM\Models\Task $task
 */
class AmoCrmManager
{
    /**
     * The config instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The AmoCRM client instance.
     *
     * @var \AmoCRM\Client
     */
    protected $client;

    /**
     * Create a new manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get the config instance.
     *
     * @return \Illuminate\Contracts\Config\Repository
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the AmoCRM client instance.
     *
     * @return \AmoCRM\Client
     */
    public function getClient()
    {
        if (!$this->client instanceof Client) {
            $this->client = new Client(
                $this->config['amocrm.domain'],
                $this->config['amocrm.login'],
                $this->config['amocrm.hash']
            );
        }

        return $this->client;
    }

    /**
     * Dynamically pass methods to AmoCRM client instance.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return call_user_func_array([$this->getClient(), '__get'], [$property]);
    }
}
