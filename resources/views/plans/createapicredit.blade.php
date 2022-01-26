@php


header("Access-Control-Allow-Origin: *");

        // variaveis globais
    $access_token = '3d8426e36056cca8d1273e621577f47f14b2303a7fcd68fb20ce77e41721fafb';
    $asaas_url_cliente = "https://www.asaas.com/api/v3/customers";
    $asaas_url_cobrança = "https://www.asaas.com/api/v3/subscriptions";
    $id_cliente = '';
    $plataforma_integracao_efetuada_com_sucesso = false;
    $plataforma_integracao_efetuada_etapa = 0;
    $response_status_atual = '';

    // registra no SQL o pedido
        ini_set('max_execution_time', '300'); //300 seconds = 5 minutes



        // require('../database/connection.php');


    $cliente_email = $thePOST['customer_email'];
    $cliente_nome = $thePOST["client_name"];
    $cliente_phone = $thePOST['client_phone'];
    $cliente_cpfcnpj = $thePOST['client_cpfcnpj'];
    $cliente_endereco = $thePOST['whatsapp_address'];
    $cliente_pedido_id = $thePOST['id']; // id do restaurante
    $cliente_restaurante_url = $thePOST['restorant']; // url restaurante
        $cliente_restaurante_url = $cliente_email;

    $cliente_pedido_preco = $thePOST['plano']; // preco do plano
    $cliente_pedido_recorrencia = "MONTHLY";

        // $opcao_pagamento_cliente = 'BOLETO';
        $opcao_pagamento_cliente = 'CREDIT_CARD';
        // $opcao_pagamento_cliente = 'UNDEFINED';


    // testagem:
    /*
    $cliente_email = "lucasbritoweb@gmail.com";
    $cliente_nome = "Lucas Zap Webhook";
    $cliente_phone = '69981254086';
    $cliente_cpfcnpj = '03496545224';
    $cliente_endereco = "Av. Paulista";
    $cliente_pedido_id = '32';
    $cliente_pedido_preco = 49.90;
    $cliente_restaurante_url = "https://app.zapentrega.com/r/zapsac";
    */
    $mensal_ou_anual = "Mensal";

    if($cliente_pedido_preco == "2") {
        $cliente_pedido_preco = 49.90;
    }
    else {
        $cliente_pedido_recorrencia = "YEARLY";
        $mensal_ou_anual = "Anual";
        $cliente_pedido_preco = 249.90;
    }




    // Pedido #613 do cliente () - restaurante teste final2

        $cobranca_description = "Assinatura Plano " . $mensal_ou_anual . " #" . $cliente_pedido_id . " do cliente " . $cliente_nome . " (" . $cliente_phone . ")" . " - " . $cliente_restaurante_url;


                        /*
                        $titulo = "#" . $cliente_pedido_id . '=' . date("Y-m-d h:s");
                        $ordem = 5;
                        $link = 'http://inicio';
                        $categoria_array_post = $response_status_atual . $thePOST;
                        $categoria_array_post = http_build_query($categoria_array_post);
                        $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $cobranca_description . "', '" . $ordem . "', '" . $link . "', '" . $categoria_array_post . "');";

            $registerResult = $conn->query($updatePassword);
                        */



    // POST/ARRAY com informações do cliente
        $post_vars = array(
                "name" => $cliente_nome,
                "email" => $cliente_email,
                //"email" => "lucasbritoweb@gmail.com",
                // "email" => "contato@zapentrega.com",
                "phone" => $cliente_phone,
                "mobilePhone" => $cliente_phone,
                "cpfCnpj" => "03496545224",
                "postalCode" => "",
                "address" => $cliente_endereco,
                "addressNumber" => "",
                "complement" => "",
                "province" => "",
                "externalReference" => "",
                "notificationDisabled" => false,
                "additionalEmails" => "",
                "municipalInscription" => "",
                "stateInscription" => "",
                "observations" => "Cliente Webhook Zap"
                );




        // cria a URL de POST com todas as informações do cliente
        $post_vars_url = http_build_query($post_vars);
        $asaas_url_cliente = $asaas_url_cliente . '?' . $post_vars_url;
        $post_vars_boleto_array = '';




                        // define os parametros para realizar a integração com o ASAAS
                        $ch = \curl_init();
                        curl_setopt($ch, CURLOPT_URL, $asaas_url_cliente);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                                curl_setopt($ch, CURLOPT_POST, 0);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Content-Type: application/json',
                           'access_token: ' . $access_token
                        ));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);


                        // executa a integração ASAAS
                        $response = curl_exec($ch);

                        if($response != false) {
                                        // realiza a captura do id do novo cliente
                                        $id_cliente = json_decode($response);
                                        $id_cliente = $id_cliente->id;
                        }

                        // var_dump($response);

                        $response_status_atual = $response;


                                        if($response != false) {
                                                        // realiza a captura do id do novo cliente
                                                $plataforma_integracao_efetuada_etapa = 1;
                                                        $id_cliente = json_decode($response);
                                                        $id_cliente = $id_cliente->id;

                                                        /*
                                                        $titulo = "#" . $cliente_pedido_id . '=' . date("Y-m-d h:s");
                                                        $ordem = 5;
                                                        $link = 'http://SUCCESS-cliente: ' . $response;
                                                        $categoria_array_post = $response_status_atual . $thePOST;
                                                        $categoria_array_post = http_build_query($categoria_array_post);
                                                        $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $cobranca_description . "');";
                                                    $registerResult = $conn->query($updatePassword);
                                                    */

                                                        $clienteCriado = true;




                                                                        // echo 'Sucesso cobrança';


                                                            $cobranca_description = "Assinatura Plano " . $mensal_ou_anual ." #" . $cliente_pedido_id . " do cliente " . $cliente_nome . " (" . $cliente_phone . ")" . " - " . $cliente_restaurante_url;

                                                                    $post_vars_boleto_array = array(
                                                                        "customer" => $id_cliente,
                                                                        "billingType" => $opcao_pagamento_cliente,
                                                                        "nextDueDate" => date('Y-m-d'),
                                                                        "value" => $cliente_pedido_preco,
                                                                        "cycle" => $cliente_pedido_recorrencia,
                                                                        "description" => $cobranca_description
                                                                    );

                                                                    // var_dump($post_vars_boleto_array);


                                                                        // cria a URL BOLETO de POST com todas as informações do cliente
                                                                        $post_vars_boleto = http_build_query($post_vars_boleto_array);
                                                                        $asaas_url_cobrança = $asaas_url_cobrança . '?' . $post_vars_boleto;


                                                                        // define os parametros para realizar a integração com o ASAAS
                                                                        $ch2 = \curl_init();
                                                                        curl_setopt($ch2, CURLOPT_URL, $asaas_url_cobrança);
                                                                                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                                                                curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, 1);
                                                                                curl_setopt($ch2, CURLOPT_TIMEOUT, 1);
                                                                                curl_setopt($ch2, CURLOPT_POST, 0);
                                                                        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                                                                           'Content-Type: application/json',
                                                                           'access_token: ' . $access_token
                                                                        ));
                                                                        curl_setopt($ch2, CURLOPT_POSTFIELDS, $post_vars_boleto);



                                                                        // executa a integração ASAAS
                                                                        $response2 = curl_exec($ch2);
                                                                        // var_dump($response2);

                                                                        if($response2 != false) {
                                                                               $plataforma_integracao_efetuada_etapa = "2.0";



                                                                               // start assinatura url

                                                                               $id_assinatura = json_decode($response2);
                                                                               $id_assinatura = $id_assinatura->id;


                                                                                   $post_vars_boleto_array_url = array(
                                                                                       "id" => $id_assinatura
                                                                                   );

                                                                               // cria a URL BOLETO de POST com todas as informações do cliente
                                                                               $post_vars_boleto_url = http_build_query($post_vars_boleto_array_url);
                                                                               $asaas_url_cobrança = $asaas_url_cobrança . '?' . $post_vars_boleto_url;


                                                                               // define os parametros para realizar a integração com o ASAAS
                                                                               $ch3 = \curl_init();
                                                                               curl_setopt($ch3, CURLOPT_URL, "https://www.asaas.com/api/v3/subscriptions/" . $id_assinatura . "/payments");
                                                                                       curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                                                                                       curl_setopt($ch3, CURLOPT_CONNECTTIMEOUT, 1);
                                                                                       curl_setopt($ch3, CURLOPT_TIMEOUT, 1);
                                                                                       curl_setopt($ch3, CURLOPT_POST, 0);
                                                                               curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
                                                                                  'Content-Type: application/json',
                                                                                  'access_token: ' . $access_token
                                                                               ));

                                                                               // executa a integração ASAAS
                                                                               $response3 = curl_exec($ch3);
                                                                               $url_assinatura = json_decode($response3);
                                                                               $url_assinatura = json_encode($url_assinatura->data[0]);
                                                                               $url_assinatura = json_decode($url_assinatura, true);
                                                                               $url_assinatura_html = $url_assinatura['bankSlipUrl'];
                                                                               $url_assinatura_html = $url_assinatura['invoiceUrl'];
                                                                               // print_r($url_assinatura['invoiceUrl']);

                                                                               // end assinatura url



                                                                               // $titulo = "#" . $cliente_pedido_id . '=' . date("Y-m-d h:s");
                                                                               //$ordem = 5;
                                                                               //$link = 'http://SUCCESS-assinatura: ' . $response3;
                                                                               // $categoria_array_post = $response_status_atual . $thePOST;
                                                                               // $categoria_array_post = http_build_query($categoria_array_post);
                                                                               // $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $cobranca_description . "');";
                                                                                   // $registerResult = $conn->query($updatePassword);
                                                                                

                                                                               $clienteCriado = true;
                                                                               $plataforma_integracao_efetuada_com_sucesso = true;


                                                                               $plataforma_integracao_efetuada_etapa = 3;
                                                                               echo 'Assinatura criada com sucesso. URL: ' . $url_assinatura_html;























                                                                        }
                                                                        else {
                                                                               $plataforma_integracao_efetuada_etapa = "2.1";


                                                                               /*
                                                                               $titulo = "#" . $cliente_pedido_id . '=' . date("Y-m-d h:s");
                                                                               $ordem = 5;
                                                                               $link = 'http://FAIL-assinatura: ' . $response2;
                                                                               $categoria_array_post = $response_status_atual . $thePOST;
                                                                               $categoria_array_post = http_build_query($categoria_array_post);
                                                                               $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $cobranca_description . "');";
                                                                                   $registerResult = $conn->query($updatePassword);
                                                                               */

                                                                               $clienteCriado = true;


                                                                        }




                                        }
                                        else {
                                        $plataforma_integracao_efetuada_etapa = "2.2";

                                        /*
                                                $titulo = "#" . $cliente_pedido_id . '=' . date("Y-m-d h:s");
                                                $ordem = 5;
                                                $link = 'http://FAIL-cliente: ' . $response;
                                                $categoria_array_post = $response_status_atual . $thePOST;
                                                $categoria_array_post = http_build_query($categoria_array_post);
                                                $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $cobranca_description . "');";
                                            $registerResult = $conn->query($updatePassword);
                                            */

                                                $clienteCriado = true;

                                        }

                                        // $response_status_atual = http_build_query($response);

                                        if($plataforma_integracao_efetuada_com_sucesso == false) {
                                                echo "Falha na comunicação com a plataforma ASAAS: " . $plataforma_integracao_efetuada_etapa;
                                        }



@endphp
