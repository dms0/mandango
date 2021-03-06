<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango;

/**
 * Connection.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class Connection
{
    private $uri;
    private $dbName;
    private $options;

    private $loggerCallable;
    private $logDefault;

    private $client;
    private $database;

    /**
     * Constructor.
     *
     * @param string $uri     The connection uri.
     * @param string $dbName  The database name.
     * @param array  $options The \Mongo options (optional).
     *
     * @api
     */
    public function __construct($uri, $dbName, array $options = array())
    {
        $this->uri = $uri;
        $this->dbName = $dbName;
        $this->options = $options;
    }

    /**
     * Sets the uri.
     *
     * @param string $uri The uri.
     *
     * @throws \LogicException If the client is initialized.
     *
     * @api
     */
    public function setUri($uri)
    {
        if (null !== $this->client) {
            throw new \LogicException('The client has already been initialized.');
        }

        $this->uri = $uri;
    }

    /**
     * Returns the uri.
     *
     * @return string $uri The uri.
     *
     * @api
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the db name.
     *
     * @param string $dbName The db name.
     *
     * @throws \LogicException If the database is initialized.
     *
     * @api
     */
    public function setDbName($dbName)
    {
        if (null !== $this->database) {
            throw new \LogicException('The database is initialized.');
        }

        $this->dbName = $dbName;
    }

    /**
     * Returns the database name.
     *
     * @return string The database name.
     *
     * @api
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * Sets the options.
     *
     * @param array $options An array of options.
     *
     * @throws \LogicException If the client is initialized.
     *
     * @api
     */
    public function setOptions(array $options)
    {
        if (null !== $this->client) {
            throw new \LogicException('The client has already been initialized.');
        }

        $this->options = $options;
    }

    /**
     * Returns the options.
     *
     * @return array The options.
     *
     * @api
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        if (null === $this->client) {
            $this->client = new \MongoDB\Client($this->uri, $this->options);
        }

        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase()
    {
        if (null === $this->database) {
            $this->database = $this->getClient()->selectDatabase($this->dbName);
        }

        return $this->database;
    }
}
