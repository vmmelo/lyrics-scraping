<?php

use Ramsey\Uuid\Rfc4122\Validator as UuidValidator;

/**
 * Method responsible for returning validation messages
 *
 * @param Object $errors
 * @return string
 *
 */
function returnErrorMessagesValidation($errors)
{

    // LOOP IN ALL ERRORS MSGS
    $message_error = [];
    foreach ($errors->all() as $message) {
        $message_error[] = $message;
    }

    return implode('|', $message_error);

}

/**
 * Method responsible for handling validation messages
 *
 * @param Object $errors
 * @return string
 *
 */
function handleErrorMessagesValidation($errors)
{

    if (strpos($errors, '|') !== false)
        return explode('|', $errors);

    return $errors;

}

function handleErrorGeneralString($erro)
{

    return [
        'status' => false,
        'validacao' => [
            'falhou' => true,
            'retorno' => [
                'generico' => $erro
            ]
        ],
        'retorno' => [],
    ];

}

/**
 * Method responsible for validate general data
 *
 * @param array $params
 * @param array $validation
 * @param array $messages
 * @return string
 *
 */
function handleErrorGeneralData($params, $validations, $messages = [])
{

    $multiple = !empty($params[0]);
    $rules = [];
    if ($multiple) {
        foreach ($validations as $validation => $rule) {
            $rules['*.' . $validation] = $rule;
        }
    } else {
        foreach ($validations as $validation => $rule) {
            $rules[$validation] = $rule;
        }
    }

    $validator = Validator::make($params, $rules, $messages);

    $retorno = [];
    $falhou = $validator->fails();
    if ($falhou) {
        $erros = $validator->errors()->toArray();
    }

    if ($multiple) {

        foreach ($params as $key => $param) {
            foreach ($validations as $field => $rule) {
                $retorno[$key][$field] = ['status' => true];
                //verificando se existe erro para o campo
                if (!empty($erros[$key . '.' . $field])) {
                    //removendo a label do campo das mensagens
                    foreach ($erros[$key . '.' . $field] as &$erro) {
                        $erro = str_replace(' ' . $key . '.' . $field . ' ', ' ', $erro);
                    }

                    $retorno[$key][$field]['status'] = false;
                    $retorno[$key][$field]['erros'] = $erros[$key . '.' . $field];
                }
            }
        }

    } else {

        foreach ($params as $param) {
            foreach ($validations as $field => $rule) {
                $retorno[$field] = ['status' => true];
                //verificando se existe erro para o campo
                if (!empty($erros[$field])) {
                    //removendo a label do campo das mensagens
                    foreach ($erros[$field] as &$erro) {
                        $erro = str_replace($field . ' ', ' ', $erro);
                    }

                    $retorno[$field]['status'] = false;
                    $retorno[$field]['erros'] = $erros[$field];
                }
            }
        }

    }

    return compact('falhou', 'retorno');

}

/**
 * Method responsible for checking if uuid is valid
 *
 * @param String $string
 * @return boolean
 *
 */
function checkUuidIsValid(String $string)
{

    $uuiValidate = new UuidValidator();
    if ($uuiValidate->validate($string)) {
        return true;
    }

    return false;

}

function cpfIsValid(String $cpf)
{

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf{$c} * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf{$c} != $d) {
            return false;
        }
    }
    return true;

}

function formatCpfCnpj($cpfCnpj){

    // Retirando tudo que não for número.
    $cpfCnpj = preg_replace("/[^0-9]/", "", $cpfCnpj);
    $tipoDado = NULL;
    if(strlen($cpfCnpj)==11){
        $tipoDado = "cpf";
    }
    if(strlen($cpfCnpj)==14){
        $tipoDado = "cnpj";
    }
    switch($tipoDado){
        default:
            $cpfCnpjFormatado = "Não foi possível definir tipo de dado";
            break;

        case "cpf":
            $bloco_1 = substr($cpfCnpj,0,3);
            $bloco_2 = substr($cpfCnpj,3,3);
            $bloco_3 = substr($cpfCnpj,6,3);
            $dig_verificador = substr($cpfCnpj,-2);
            $cpfCnpjFormatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;
            break;

        case "cnpj":
            $bloco_1 = substr($cpfCnpj,0,2);
            $bloco_2 = substr($cpfCnpj,2,3);
            $bloco_3 = substr($cpfCnpj,5,3);
            $bloco_4 = substr($cpfCnpj,8,4);
            $digito_verificador = substr($cpfCnpj,-2);
            $cpfCnpjFormatado = $bloco_1.".".$bloco_2.".".$bloco_3."/".$bloco_4."-".$digito_verificador;
            break;
    }
    return $cpfCnpjFormatado;
}
