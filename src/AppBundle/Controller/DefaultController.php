<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hateoas\HateoasBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
     * @Route("/", name="homepage")
     */
  public function indexAction()
  {
    return $this->render('AppBundle::Puzzle/puzzle.html.twig');
  }

  /**
   * @Route("/esculturas", name="esculturas")
   */
  public function esculturasAction()
  {
    $esculturas = $this->traerNodos();

    return $this->render('AppBundle::Esculturas/esculturas.html.twig', array(
        'esculturas' => $esculturas,
      )
    );
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
    			
    			$titulo = "no dispone titulo";
    			$tipo = "desconocido";
    			$ubicacion = "desconocida";
    			$material = "desconocido";
    			$autor = "desconocido";
    			$anio = "desconocido";
    			$mapa = array(
    				'lat' => "-",
    				'long' => "-",
    			);
    			$foto = "no existe";
    			$escultura = $this->traerEscultura($nodo["uri"]);
    			if ($escultura["title"]){
    				$titulo = $escultura["title"];
    			}
    			if ($escultura["field_tipo"]["und"][0]["tid"]){
    				$tipo = $this->infoTid($escultura["field_tipo"]["und"][0]["tid"]); 
    			}
    			if ($escultura["field_material"]["und"][0]["tid"]){
    				$material = $this->infoTid($escultura["field_material"]["und"][0]["tid"]); 
    			}
    			if ($escultura["field_ubicacion"]["und"][0]["value"]){
    				$ubicacion = $this->infoTid($escultura["field_ubicacion"]["und"][0]["value"]); 
    			}
    			if ($escultura["field_fotos"]["und"][0]["filename"]){
    				$foto = "
http://www.resistenciarte.org/sites/resistenciarte.org/files/" . $escultura["field_fotos"]["und"][0]["filename"];
    			}
    			$arrayEsculturas[$key] = array(
    				'titulo' => $titulo,
    				'imgUrl' => $foto,
    				'tipo' => $tipo,
    				'ubicacion' => $ubicacion,
    				'material' => $material,
    				'autor' => $autor,
    				'anio' => $anio,
    				'mapa' => $mapa,
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

    public function infoTid($tid){

    	$url = "http://www.resistenciarte.org/api/v1/taxonomy_term/" . $tid;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
    	$data = json_decode($response, true);
    	
    	$laData = $data["name"];
    	return $laData;
    }
}
