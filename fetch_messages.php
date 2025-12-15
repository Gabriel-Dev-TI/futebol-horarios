<?php
// Inclua o arquivo de conexão e defina o fuso horário (muito importante!)
include('conexao.php'); 
date_default_timezone_set('America/Sao_Paulo'); 

// Consulta para buscar mensagens do dia atual (a mesma que você já tem)
$mensagem = "
    SELECT nome, mensagem, data_envio
    FROM chat INNER JOIN usuario ON usuario.nome = chat.usuario
    WHERE DATE(data_envio) = CURDATE()
    ORDER BY data_envio ASC;
";

$resultados = mysqli_query($conexao, $mensagem);

if(mysqli_num_rows($resultados) > 0){
    // Inicia um buffer para armazenar o HTML
    $output = '';
    
    while($tupla = mysqli_fetch_assoc($resultados)){
        // Formata a hora da mesma forma que você fez no index.php
        $dataEnvio = date('H:i', strtotime($tupla['data_envio']));
        
        // Constrói o HTML da mensagem
        $output .= "<p id=\"mensagem\"><span class=\"destaque\">[".$dataEnvio."] ".$tupla['nome']." :</span> ".$tupla['mensagem']."</p>";
    }
    
    // Imprime o HTML. O AJAX irá capturar esta saída.
    echo $output;
} else {
    // Se não houver mensagens, retorna algo vazio ou uma mensagem de "sem mensagens"
    echo "Nenhuma mensagem no momento.";
}

// Opcional: fechar a conexão se você não estiver fazendo isso em outro lugar
// mysqli_close($conexao);
?>