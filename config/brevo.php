<?php 

function enviar_email($destinatario, $nome, $assunto, $mensagem)
{

    $apikey = "";

    $dados = [
        "sender" => [
            "name" => "Treefolio",
            "email" => "treefolio0@gmail.com"
        ],
        "to" => [
            [
                "email" => $destinatario,
                "name" => $nome
            ]
        ],
        "subject" => $assunto,
        "htmlContent" => $mensagem
    ];


   
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,

        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "api-key: ".$apikey,
            "content-type: application/json"
        ],

        CURLOPT_POSTFIELDS => json_encode($dados)
    ]);

    $resposta = curl_exec($curl);

    $erro = curl_error($curl);

    curl_close($curl);

    if($erro){
        return "Erro: ".$erro;
    }

    return $resposta;

}
?>