<?php

namespace AppBundle\Service;

/**
 * @Service("apc.service")
 */
class APCService
{
    protected $cachePrefix = '';
    protected $session;
    protected $environment;

    /**
     * @InjectParams({
     *     "session"     = @Inject("session"),
     *     "environment" = @Inject("%kernel.environment%"),
     * })
     * @param Session $session
     * @param string  $environment
     */
    public function __construct(
        Session $session,
        $environment
    )
    {
        $this->session     = $session;
        $this->environment = $environment;

        $this->cachePrefix = $session->getName() . '-' . $environment .'-';
    }

    /**
     * Removes a stored variable from the cache
     * @param  string $key Cache key
     * @return boolean
     */
    public function delete($key)
    {
        return apc_delete($this->cachePrefix.$key);
    }

    /**
     * Cache a variable in the data store
     * @param  string  $key
     * @param  mixed  $value
     * @param  integer $ttl   Time to live in seconds. If 0, persist until cache clear.
     * @return boolean
     */
    public function store($key, $value, $ttl = 0)
    {
        $bool = apc_store($this->cachePrefix.$key, $value, $ttl);
        return $bool;
    }

    /**
     * Fetch a stored variable from the cache
     * @param  string   $key
     * @param  boolean &$success    Set to TRUE in success and FALSE in failure.
     * @return mixed
     */
    public function fetch($key, &$success)
    {
        try {
            $result = apc_fetch($this->cachePrefix.$key, $success);
        } catch (Exception $e) {
            $success = false;
            $result  = null;
        }
        return $result;
    }

    /**
     * Check if key exists in cache
     * @param  string $key
     * @return boolean
     */
    public function exists($key)
    {
        return apc_exists($this->cachePrefix.$key);
    }

    /**
     * Gets value from APC, if not stored use callback to get value
     *
     * @param  string   $key
     * @param  callable $callback Function to execute, works with scope ($this->{varName})!
     * @param  integer  $ttl      time to live: If 0 persist until the server restart
     * @param  bool     $rewrite
     *
     * @return mixed
     */
    public function get($key, callable $callback, $ttl = 0, $rewrite = false)
    {
        // Gets value from APC
        $value = $this->fetch($key, $success);

        // If value doesn't exists
        if ($rewrite OR !$success OR
            (gettype($value)=='object' &&
                get_class($value)=='__PHP_Incomplete_Class'))
        {
            // Gets value from callback
            $value = $callback();

            // Stores value
            $this->store($key, $value, $ttl);
        }
        return $value;
    }
}