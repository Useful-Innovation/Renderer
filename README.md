# Renderer
A rendering class that supports many include paths.

## Usage

    $renderer = new Renderer(new Config([
      __DIR__ . '/path1/to/templates',
      __DIR__ . '/path2/to/templates'
    ], Config::TYPE_HTML);
    
    // Will look for 'template.html.php' in the added paths, create a variable called $title in 
    // the included file, with the given value, and return the HTML-code
    $renderer->render('template', ['title' => 'Lorem ipsum']); 
