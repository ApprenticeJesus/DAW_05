<?php

/**
 * @internal I.E.S. Aguadulce
 * @internal Desarrollo de Aplicaciones Web 2020-2021
 * @internal Despiegue de Aplicaciones Web UT05
 * @author: Juan Jesús Rivera León
 * @version 1.1.
 */

$url = ("https://world.openfoodfacts.org/api/v0/product/"); //Usamos la dirección del archivo de servicio.

if(isset($_GET) && isset($_GET['food'])){ //Comprobamos si se ha introducido alguna petición por formulario.

    $plato = $_GET['food']; //Asignamos la petición recibida a una variable.

}
/**Recibe los atributos de dirección URL y la consulta a realizar
 * @param $url, es la dirección del API al que hacemos la llamada
 * @param $params, es la petición que hacemos al API, se une a los sufijos y prefijos necesarios para activar
 * las funciones de la API y devuelve 
 * @result $resultado, el resultado de la petición en formato cadena.
 */
function get($url, $params = null)
        {
                 $ch = curl_init(); /**
                                      *Crea un nuevo recurso cURL
                                      */
                 $tail=!empty($params)?$params.'.json':''; /**Generamos una cadena de consulta de acuerdo con la API 
                 *o le asignamos un valor vacío.*/
                 curl_setopt($ch, CURLOPT_URL, $url.$tail);   /**Se definen las opciones de nuestra sesión cURL.
                 *en esta primera línea se fija la URL a buscar.
                  */                              
                 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);/**Asignando a esta opción el valor '1'(true), se pide a la librería 
                 *que acepte cualquier dirección (header) que llegue.
                 */
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); /**Se asigna la respuesta a la variable $ch y el valor
                 *'1'(true) pide esta respuesta como cadena.
                 * */
                 $output = curl_exec($ch); /**Asignamos a la variable '$output' el resultado de la ejecución de la sesión. */       
                 curl_close($ch);   /**Cerramos la sesión cURL. */  
                 return $output; /**La función devuelve el resultado de la sesión. */
        }

        $resultado = isset($plato)?get($url,$plato):get($url,''); /**Hacemos la petición al servicio, supliendo el caso
        *de que no haya ningun plato introducido, y asignamos el resultado a una variable, para su procesado.*/
        
        $producto = json_decode($resultado); //Extraemos las variables que queremos mostrar.

        $owner = isset($producto->product->brand_owner)?$producto->product->brand_owner:'Propietario no disponible.';

        $categ = isset($producto->product->categories)?$producto->product->categories:'Categoría por determinar.';

        $marca = isset($producto->product->product_name)?$producto->product->product_name:'Debe elegir el producto.';

        $imagen = isset($producto->product->image_nutrition_small_url)?$producto->product->image_nutrition_small_url:'Imagen no disponible.';
?>