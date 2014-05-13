<?php


namespace PhrestAPI\Collections;

class Collection
{
  /** @var string */
  public $name;

  /** @var string */
  public $controller;

  /** @var string */
  public $prefix;

  /** @var CollectionRoute[] */
  public $routes;
}
