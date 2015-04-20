<?php

use GoBrave\Renderer\Renderer as R;
use GoBrave\Renderer\Config as C;

class RendererTest extends PHPUnit_Framework_Testcase
{
  public static $dir1 = __DIR__ . '/dir1';
  public static $dir2 = __DIR__ . '/dir2';
  public static $dir3 = __DIR__ . '/dir3';

  public function setUp() {

  }

  public function testRenderRegularTemplate() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));

    $html = $renderer->render('template');
    $this->assertSame($html, '<h1>Template in dir 1</h1>' . PHP_EOL);

    $txt = $renderer->render('template', [], C::TYPE_TXT);
    $this->assertSame($txt, 'Template in dir 1' . PHP_EOL);
  }

  public function testRenderRegularTemplateInParentFolder() {
    $renderer = new R(new C([self::$dir2, self::$dir1], C::TYPE_HTML)); // $dir2 BEFORE $dir1
    $html = $renderer->render('template');
    $this->assertSame($html, '<h1>Template in dir 2</h1>' . PHP_EOL);

    $renderer->setConfig(new C([self::$dir1, self::$dir2], C::TYPE_HTML)); // $dir1 BEFORE $dir2
    $html = $renderer->render('template');
    $this->assertSame($html, '<h1>Template in dir 1</h1>' . PHP_EOL);
  }

  public function testRenderWithVariables() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));

    $html = $renderer->render('vars', ['title' => 'Lorem ipsum']);
    $this->assertSame($html, '<h1>Lorem ipsum</h1>' . PHP_EOL);
  }

  public function testRenderWithDefaultVariables() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));
    $renderer->addVars(['title' => 'Lorem ipsum']);

    $html = $renderer->render('vars');
    $this->assertSame($html, '<h1>Lorem ipsum</h1>' . PHP_EOL);
  }

  public function testDefaultVariablesWriteProtected() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));
    $renderer->addVars(['title' => 'Lorem ipsum']);
    $renderer->addVars(['title' => 'Dolor sit amet']);

    $html = $renderer->render('vars');
    $this->assertSame($html, '<h1>Lorem ipsum</h1>' . PHP_EOL);
  }

  public function testAppendTemplatePath() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));
    $renderer->appendPath(self::$dir3);

    $html = $renderer->render('template');
    $this->assertSame($html, '<h1>Template in dir 1</h1>' . PHP_EOL);
  }

  public function testPrependTemplatePath() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));
    $renderer->prependPath(self::$dir3);

    $html = $renderer->render('template');
    $this->assertSame($html, '<h1>Template in dir 3</h1>' . PHP_EOL);
  }


  /**
   * @expectedException \GoBrave\Renderer\RendererException
   */
  public function testRenderMissingTemplate() {
    $renderer = new R(new C([self::$dir1], C::TYPE_HTML));
    $renderer->render('missing_template');
  }
}
