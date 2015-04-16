<?php
/**
 * This file is part of the Money library
 *
 * Copyright (c) 2011-2013 Mathias Verraes
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Money;

class Currency implements \Serializable
{
    /** @var string */
    protected $name;

    /** @var array */
    protected static $currencies;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        if(!isset(static::$currencies)) {
            static::$currencies = require __DIR__.'/currencies.php';
        }

        $this->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->name = unserialize($serialized);
    }

    /**
     * @param string $name
     *
     * @return $this
     *
     * @throws UnknownCurrencyException
     */
    public function setName($name)
    {
        if (!array_key_exists($name, static::$currencies)) {
            throw new UnknownCurrencyException($name);
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Money\Currency $other
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $this->name === $other->getName();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
