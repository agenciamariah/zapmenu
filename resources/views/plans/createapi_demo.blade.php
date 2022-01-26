@php


	// variaveis globais
    $access_token = '3d8426e36056cca8d1273e621577f47f14b2303a7fcd68fb20ce77e41721fafb';
    $asaas_url_cliente = "https://www.asaas.com/api/v3/customers";
    $asaas_url_cobrança = "https://www.asaas.com/api/v3/subscriptions";
    $id_cliente = '';

    // registra no SQL o pedido




	        // require('../database/connection.php');

			$titulo = date("Y-m-d h:s");
			$ordem = 5;
			$link = 'http://pedido';
			$categoria_array_post = $_POST;
			$categoria_array_post = http_build_query($categoria_array_post);
			// $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $categoria_array_post . "');";
			   


            // $registerResult = $conn->query($updatePassword);


    // POST/ARRAY com informações do cliente
	$post_vars = array(
	        "name" => "Zap Webhook",
	        "email" => "lucasbritoweb@gmail.com",
	        // "email" => "contato@zapentrega.com",
	        "phone" => "4738010919",
	        "mobilePhone" => "69981254086",
	        "cpfCnpj" => "03496545224",
	        "postalCode" => "01310-000",
	        "address" => "Av. Paulista",
	        "addressNumber" => "150",
	        "complement" => "Sala 201",
	        "province" => "Centro",
	        "externalReference" => "12987382",
	        "notificationDisabled" => false,
	        "additionalEmails" => "marcelo.almeida2@gmail.com,marcelo.almeida3@gmail.com",
	        "municipalInscription" => "46683695908",
	        "stateInscription" => "646681195275",
	        "observations" => "ótimo pagador, nenhum problema até o momento"
	        );


	// cria a URL de POST com todas as informações do cliente
	$post_vars_url = http_build_query($post_vars);
	$asaas_url_cliente = $asaas_url_cliente . '?' . $post_vars_url;



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



			// verifica se a integração ocorreu corretamente
			if($response != false) {


			// realiza a captura do id do novo cliente
			$id_cliente = json_decode($response);
			$id_cliente = $id_cliente->id;



			$titulo = date("Y-m-d h:s");
			$ordem = 5;
			$link = 'http://';
			$categoria = $categoria_array_post . ' ==== ' .  $response;
			// $updatePassword = "INSERT INTO `app` (`id`, `titulo`, `link`, `ordem`, `categoria`) VALUES (NULL, '" . $titulo . "', '" . $ordem . "', '" . $link . "', '" . $categoria . "');";
			   


            // $registerResult = $conn->query($updatePassword);
            echo 'Success!<br/><br/>';
            //var_dump($response);
            echo '<br/><br/> id: ';
            print_r($id_cliente);
            echo '<br/><br/>';







		    $post_vars_boleto_array = array(
		        "customer" => $id_cliente,
		        "billingType" => "BOLETO",
		        "nextDueDate" => date('Y-m-d'),
		        "value" => 49.90,
        		"cycle" => "MONTHLY",
	        	"externalReference" => "12987382",
		        "description" => "Assinatura Plano PRO"
		    );




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



			// verifica se a integração ocorreu corretamente
			if($response2 != false) {

			/* 
		string(415) "{"object":"subscription",
		"id":"sub_Fhz1NcLwyKfA",
		"dateCreated":"2021-09-13",
		"customer":"cus_000023815142",
		"paymentLink":null,
		"value":49.90,
		"nextDueDate":"2021-10-13",
		"cycle":"MONTHLY",
		"description":"Assinatura Plano PRO",
		"billingType":"BOLETO",
		"deleted":false,
		"status":"ACTIVE",
		"externalReference":null,
		"sendPaymentByPostalService":false,
		"fine":{"value":0,
		"type":"FIXED"},
		"interest":{"value":0,
		"type":"PERCENTAGE"}}"

			*/


            echo 'Success ASSINATURA!<br/><br/>';
            // var_dump($response2);
            echo '<br/><br/> id: ';

			$id_assinatura = json_decode($response2);
			$id_assinatura = $id_assinatura->id;

            print_r($id_assinatura);

            echo '<br/><br/>';



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
			// curl_setopt($ch3, CURLOPT_POSTFIELDS, $post_vars_boleto_url);



			// executa a integração ASAAS
			$response3 = curl_exec($ch3);
			$url_assinatura = json_decode($response3);
			$url_assinatura = json_encode($url_assinatura->data[0]);
			$url_assinatura = json_decode($url_assinatura, true);
			
			echo '<br/><br/>';
			print_r($url_assinatura['invoiceUrl']);
			//echo $url_assinatura;
			/*

			"{"object":"payment",
			"id":"pay_6222928230421050",
			"dateCreated":"2021-09-13",
			"customer":"cus_000023816962",
			"subscription":"sub_WiScnd7D7tEa",
			"paymentLink":null,
			"value":49.89999999999999857891452847979962825775146484375,
			"netValue":48.909999999999996589394868351519107818603515625,
			"originalValue":null,
			"interestValue":null,
			"description":"Assinatura Plano PRO",
			"billingType":"BOLETO",
			"status":"PENDING",
			"dueDate":"2021-09-13",
			"originalDueDate":"2021-09-13",
			"paymentDate":null,
			"clientPaymentDate":null,
			"invoiceUrl":"https:\/\/www.asaas.com\/i\/6222928230421050",
			"invoiceNumber":"67992132",
			"externalReference":"12987382",
			"deleted":false,
			"anticipated":false,
			"creditDate":null,
			"estimatedCreditDate":null,
			"bankSlipUrl":"https:\/\/www.asaas.com\/b\/pdf\/6222928230421050",
			"lastInvoiceViewedDate":null,
			"lastBankSlipViewedDate":null,
			"discount":{"value":0,
			"limitDate":null,
			"dueDateLimitDays":0,
			"type":"FIXED"},
			"fine":{"value":0,
			"type":"FIXED"},
			"interest":{"value":0,
			"type":"PERCENTAGE"},
			"postalService":false}"

			*/


			}
			else {
				echo 'Cobrança POST retornou FALSE';
			}





















			}
			else {
				echo 'URL retornou FALSE, tentar novamente';
			}

@endphp
