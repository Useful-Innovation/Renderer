<?php

namespace GoBrave\Renderer;

class Config
{
  const TYPE_HTML = 'html';
  const TYPE_JSON = 'json';
  const TYPE_TXT  = 'txt';

  protected $paths;
  protected $type;

  public function __construct(array $paths, $type) {
    $this->setPaths($paths);
    $this->setType($type);
  }

  public function setPaths(array $paths) {
    $this->paths = $paths;
    return $this;
  }

  public function setType($type) {
    $this->type = (string)$type;
    return $this;
  }

  public function getPaths() {
    return $this->paths;
  }

  public function getType() {
    return $this->type;
  }

  public function appendPath($path) {
    array_push($this->paths, $path);
    return $this;
  }

  public function prependPath($path) {
    array_unshift($this->paths, $path);
    return $this;
  }
}
