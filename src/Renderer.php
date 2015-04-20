<?php

namespace GoBrave\Renderer;

class Renderer
{
  protected $config;
  protected $vars;

  public function __construct(Config $config) {
    $this->setConfig($config);
    $this->vars = [];
  }

  public function setConfig(Config $config) {
    $this->config = $config;
    return $this;
  }

  public function addVars(array $vars) {
    $this->vars = array_merge($vars, $this->vars);
    return $this;
  }

  public function appendPath($path) {
    $this->config->appendPath($path);
    return $this;
  }

  public function prependPath($path) {
    $this->config->prependPath($path);
    return $this;
  }

  public function render($template, array $vars = [], $type = null) {
    $type     = $type ?: $this->config->getType();
    $vars     = array_merge($this->vars, $vars);
    $template = $this->findTemplate($template, $type);
    $output   = $this->renderTemplate($template, $vars);
    $output   = trim($output);
    return $output . PHP_EOL;
  }





  /*
   * Weird variable name to prevent name collisions
   */
  protected function renderTemplate($template_158823, $vars_158823 = []) {
    ob_start();
    ob_clean();
    extract($vars_158823);
    include($template_158823);
    unset($vars_158823);
    unset($template_158823);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }

  protected function findTemplate($template, $type) {
    $template_path = false;
    foreach($this->config->getPaths() as $path) {
      $path .= '/' . trim($template, '/');
      $path .= '.' . $type . '.php';
      if(file_exists($path)) {
        $template_path = $path;
        break;
      }
    }

    if($template_path === false) {
      throw new RendererException("Template '" . implode('.', [$template, $type, 'php']) . "' is missing");
    }

    return $template_path;
  }
}
