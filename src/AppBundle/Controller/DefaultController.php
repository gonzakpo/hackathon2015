<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
   * @Route("/", name="homepage")
   */
  public function indexAction() {

    return $this->render('AppBundle::Puzzle/puzzle.html.twig');
  }


  public function traerNodos(){
    $url = 'http://www.resistenciarte.org/api/v1/node?pagesize=20';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
      $data = json_decode($response, true);
      $arrayEsculturas = array();
      foreach ($data as $key => $nodo) {
        if ($nodo["type"] == "escultura"){
          $titulo = "no tiene";
          $foto = "no tiene";
          $escultura = $this->traerEscultura($nodo["uri"]);
          //ladybug_dump_die($escultura["field_fotos"]);
          if ($escultura["title"]){
            $titulo = $escultura["title"];
          }
          if ($escultura["field_fotos"]["und"][0]["filename"]){
            $foto = "http://www.resistenciarte.org/sites/resistenciarte.org/files/" . $escultura["field_fotos"]["und"][0]["filename"];
          }
          $arrayEsculturas[$key] = array(
            'titulo' => $titulo,
            'imgUrl' => $foto,
          );
        }
      }

    return $arrayEsculturas;
  }

  public function traerEscultura($url){

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $response = curl_exec($ch);
    $data = json_decode($response, true);

    return $data;
  }

  /**
   * @Route("/esculturas", name="esculturas")
   */
  public function esculturasAction() {
    $esculturas = $this->traerNodos();

    return $this->render('AppBundle::Esculturas/esculturas.html.twig', array(
      'esculturas' => $esculturas,
    ));
  }
}
