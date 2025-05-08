<?php
include_once '../assets/db.php';
include_once '../assets/functions.php';

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);

// Ajuste este path conforme a estrutura da URL
//$basePath = '/projetos/iPrev/iPrev-P3/__dev__/src/api';
$basePath = '/projetos/iprev/p3/src/api';
$route = str_replace($basePath, '', $request);

// Divide a rota para identificar o endpoint e os parâmetros
$routeParts = explode('/', trim($route, '/'));

//Data Limite do Índice antes da Selic
$limite = "2021-13";

if (count($routeParts) >= 2) {
    $endpoint = $routeParts[0];
    $param = $routeParts[1];
    $tipoIndice = isset($routeParts[2]) ? $routeParts[2] : null; // Captura o tipo de índice, se existir
    
    switch ($endpoint) {
        case 'indice':
        if (periodoToInt($param) <= periodoToInt($limite)) {    
            $SQL = "SELECT indice FROM indices where data like '" . $param."'";
            $RS = $mysqli->query($SQL);

            // Inicializando a variável para armazenar o índice
            $indice = null; 
            if ($RS) {
                // Fetch associativo para pegar os resultados
                while ($row = $RS->fetch_assoc()) {
                    // Armazena o índice encontrado
                    $indice = $row['indice']; 
                }                                
                // Resposta JSON do indice
                echo json_encode([
                    "data" => $param,
                    "indice" => $indice
                ]);
            } else {
                echo json_encode(["error" => "Erro na consulta SQL: " . $mysqli->error]);
            }                   
        } else {
            
            $SQL = "SELECT indice FROM selic where data like '" . $param."'";
            $RS = $mysqli->query($SQL);

            // Inicializando a variável para armazenar o índice
            $indice = null; 
            if ($RS) {
                // Fetch associativo para pegar os resultados
                while ($row = $RS->fetch_assoc()) {
                    // Armazena o índice encontrado
                    $indice = $row['indice']; 
                }                                
                // Resposta JSON do indice
                echo json_encode([
                    "data" => $param,
                    "indice" => $indice
                ]);
            } else {
                echo json_encode(["error" => "Erro na consulta SQL: " . $mysqli->error]);
            }                   
        }
        break;  

        case 'processo':
            $SQL = "SELECT * FROM processos WHERE NUMERO_PROCESSO_DIGITAL = ?";
            $stmt = $mysqli->prepare($SQL);
            
            if (!$stmt) {
                echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
                break;
            }
        
            $stmt->bind_param("s", $param);
            $stmt->execute();
            $result = $stmt->get_result();            

        
            if ($result->num_rows > 0) {
                $processo = $result->fetch_assoc(); // Pegando apenas o primeiro resultado
                echo json_encode($processo);
            } else {
                echo json_encode(["error" => "Processo não encontrado"]);
            }
        
            $stmt->close();
        break;        

    }          

} else {
    // Rota inválida
    http_response_code(400);
    echo json_encode(["error" => "Rota inválida"]);
}
