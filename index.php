<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use League\Glide\Responses\SlimResponseFactory;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Urls\UrlBuilderFactory;

$signkey = '__YOUR_SECRET__'; // http://glide.thephpleague.com/1.0/config/security/

require 'vendor/autoload.php';
$server = League\Glide\ServerFactory::create([
    'source' => 'images', // full path to your images
    'cache' => 'cache', // cache folder for thumbs
    'response' => new SlimResponseFactory(),
    'max_image_size' => 2000*2000, // max img size for security
]);

$app = new \Slim\App;

$app->get('/{path:.*}', function (Request $request, Response $response) use($server) {
    try {
      global $signkey;

      $path = $request->getAttribute('path');

      // if need use signature!
      // SignatureFactory::create($signkey)->validateRequest($path, $_GET);

      $response = $server->getImageResponse($path, $_GET);
      return $response;

    } catch (Exception $e) {
       return $response->write("404");
    }
});
$app->run();
