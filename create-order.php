<?php
include 'conexao.php';
$id = $_GET['id'];
$frete = 0;
$idPedidoParceiro = 'PED-'.rand();


$consulta = $pdo->query("SELECT * FROM produtos WHERE id = $id");
$resultado = $consulta->fetch();

$variations = json_decode($resultado['variations'], true);


$sku = $variations[0]['sku'];
$ref   = $variations[0]['ref'];

$preco = (float) $resultado['price'];

    $baseUrl = "https://replicade.com.br:443/api/v1/pedido/pedido";
    // $baseUrl = "https://www.replicade.com.br:/api/v1/pedido/pedido/";

$auth = "Authorization: Basic aXdPMzVLZ09EZnRvOHY3M1I6";

$dadosPedido = [
    "pedido" => [
        "idPedidoParceiro" => $idPedidoParceiro,
        "valorFrete" => 0.00,
        "prazoEntrega" => 5,
        "valorTotalCompra" => $preco,
        "formaPagamento" => 4,

        "dadosCliente" => [
            "cpfCnpj" => "12345678900",
            "nomeRazao" => "João da Silva",
            "fantasia" => "João",
            "sexo" => "M",
            "dataNascimento" => "01-01-1990",
            "email" => "cliente@email.com",

            "dadosEntrega" => [
                "cep" => "87000000",
                "endereco" => "Rua Teste",
                "numero" => "123",
                "bairro" => "Centro",
                "complemento" => "",
                "cidade" => "Maringá",
                "uf" => "PR",
                "responsavelRecebimento" => "João da Silva"
            ],

            "telefones" => [
                "residencial" => "4433221100",
                "comercial" => "",
                "celular" => "44991234567"
            ]
        ],

        "pagamento" => [[
            "valor" => $preco,
            "quantidadeParcelas" => 1,
            "meioPagamento" => "visa"
        ]],

        "itens" => [[
            "sku" => $sku,
            "valorUnitario" => $preco,
            "quantidade" => 1
        ]]
    ]
];

$json = json_encode($dadosPedido, JSON_UNESCAPED_UNICODE);

$curl = curl_init($baseUrl);

curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $json,

    CURLOPT_HEADER => true,

    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        $auth
    ]
]);

$response = curl_exec($curl);
$http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$error = curl_error($curl);

curl_close($curl);

if ($http == 200) {
   $sql = "INSERT INTO pedidos (
    idPedidoParceiro, valorFrete, formaPagamento, sku, valorUnitario, quantidade,
    status
) VALUES (
    :idPedidoParceiro, :valorFrete, :formaPagamento, :sku, :valorUnitario, :quantidade,
    :status
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':idPedidoParceiro' => $idPedidoParceiro,
    ':valorFrete' => 0,
    ':formaPagamento' => 4,
    ':sku' => $sku,
    ':valorUnitario' => $preco,
    ':quantidade' => 1,
    ':status' => 1 //1 para novo, 2 para aprovado, 3 para recusado
]);

}else{
   echo "algo deu errado!";
   die();
}

$header = substr($response, 0, $headerSize);
$body   = substr($response, $headerSize);

echo "<pre>";
echo "========= DEBUG =========\n";
echo "URL: $baseUrl\n";
echo "HTTP CODE: $http\n";
echo "CURL ERROR: $error\n\n";

echo "--------- HEADERS DA API ---------\n";
echo $header . "\n";

echo "--------- BODY (RESPOSTA JSON) ---------\n";
echo $body . "\n";
echo "====================================\n";
echo "</pre>";

echo '<a href="product-list.php">voltar</a>';

?>
