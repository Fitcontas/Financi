<?php

namespace Financi;

/**
 * 
 */
class WebServices 
{

    /**
     * Serviços Disponíveis
     * http://fitcontas.com.br/fitservices/estados - Retorna todos os estados
     * http://fitcontas.com.br/fitservices/cidade/:id - Retorna uma cidade pelo ID
     * http://fitcontas.com.br/fitservices/cidades_por_uf/:uf - Retorna as cidades de um estados
     * http://fitcontas.com.br/fitservices/logradouro/:cep - Retorna um logradouro pelo CEP
     * http://fitcontas.com.br/fitservices/cbo/:cbo - Retorna uma ocupação pelo CBO
     * http://fitcontas.com.br/fitservices/bancos - Retorna todos os bancos
     * http://fitcontas.com.br/fitservices/banco_por_codigo/:codigo - Retorna um banco pelo código
     * http://fitcontas.com.br/fitservices/banco_por_id/:id - Retorna um banco pelo id
     * http://fitcontas.com.br/fitservices/cnae - Retorna todos os CNAE'S
     * http://fitcontas.com.br/fitservices/cnae_por_codigo/:codigo - Retorna um CNAE pelo código
     * http://fitcontas.com.br/fitservices/cnae_por_id/:id - Retorna um CNAE pelo código
     * http://fitcontas.com.br/fitservices/alineas - Retorna todos os alineas
     * http://fitcontas.com.br/fitservices/alineas/:codigo - Retorna um alineas pelo código
     * http://fitcontas.com.br/fitservices/paises - Retorna todos os paises
     * http://fitcontas.com.br/fitservices/pais/:id - Retorna um país pelo id
     */
    static function service($service, $key_value = false)
    {

        $resource = json_decode(file_get_contents('http://fitcontas.com.br/fitservices/' . $service));

        if($key_value) {
            return self::getKeyValue($resource->rows, $key_value['key'], $key_value['value']);
        }

        return $resource;
    }

    /**
     * @return Array
     */
    static function getKeyValue(Array $arr, $key, $value)
    {
        try {

            $final_arr = [];
            
            foreach ($arr as $ar_key => $ar_value) {

                $final_arr[$ar_value->$key] = $ar_value->$value;
            }

            return $final_arr;

        } catch(Exception $e) {
            throw new Exception("Error: " . $e->getMessage(), 1);
        }
    }
}