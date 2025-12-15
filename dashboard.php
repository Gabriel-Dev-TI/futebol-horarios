<?php

session_start();
include('conexao.php'); 
date_default_timezone_set('America/Sao_Paulo');

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

$usuario_logado = $_SESSION['usuario'];
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDF - Crias do Futebol</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family:Arial,sans-serif; }
        body { background:#121212; color:#fff; display:flex; flex-direction:column; align-items:center; min-height:100vh; padding:20px; }
        header { text-align:center; margin-bottom:20px; }
        header h1 { font-size:36px; color:#ffd700; }
        header p { color:#ccc; font-size:14px; margin-top:5px; }

        .container { width:100%; max-width:900px; display:flex; flex-direction:column; gap:20px; }

        .box { background:#1e1e1e; padding:15px; border-radius:5px; display:flex; flex-direction:column; gap:10px; }

        .destaque{font-size:15px;color: #ffee00ff;font-weight:bold;}
        h2 { text-align:center; font-size:20px; margin-bottom:10px; }

        label { font-size:14px; margin-bottom:5px; }
        select, input[type="text"], input[type="time"], input[type="number"], button {
            width:100%; padding:8px; margin-bottom:10px; border:none; border-radius:3px; font-size:14px; background:#333; color:#fff;
        }
        button { cursor:pointer; font-weight:bold; text-transform:uppercase; background:#0f7b34; transition:0.2s; }
        button:hover { background:#159245; }

        a { cursor:pointer; font-weight:bold; text-transform:uppercase; background:#0f7b34; transition:0.2s; }
        a:hover { background:#159245; }

        .lista-horarios, .times, .ranking-table { display:flex; flex-direction:column; gap:8px; margin-top:10px; }
        .item-horario, .time { background:#2b2b2b; padding:8px; border-radius:3px; }
        .chat-box-inner { background:#2b2b2b; padding:8px; border-radius:3px; height:400px; overflow-y:auto; margin-bottom:10px; }
        .chat-item span { font-weight:bold; color:#ffd700; }

        .footer { font-size:12px; color:#aaa; text-align:center; margin-top:5px; }

     
        .main-row { display:flex; gap:10px; flex-wrap:wrap; justify-content:space-between; }
        .main-row .box { flex: 1 1 100%; } 

    
        .ranking-footer {
            width: 100%;
            max-width: 900px; 
            margin-top: 20px;
        }

        @media (max-width: 700px) {
            .main-row {
                flex-direction: column;
            }
            .box {
                width: 100%;
            }
            header h1 {
                font-size: 28px;
            }
            header p {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>CDF</h1>
        <p>Crias do Futebol</p>
    </header>

    
    <div class="container">
        <button onclick="window.location.href = 'logout.php';">Deslogar</button>

        <div class="box">
            <h2>Agendar Horário</h2>
            <label >Quem vai Jogar?</label>
            
            <p class = "destaque"><?php echo $usuario_logado;?></p>
        
            <label for="horario-input">Qual horário?</label>

            <form action="" method = "post">
            <input type="time" id="horario-input" name="horas">
            <button id="marcarBtn" type = "submit">Marcar Presença</button>
            </form>
            

            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['horas'])){

                $horario = $_POST['horas'];
                
                $inserirHoras = "
                INSERT INTO horario_subiu(usuario,horario) VALUES('$usuario_logado','$horario');
                ";

                $result = mysqli_query($conexao,$inserirHoras);

                if(!$result){
                    echo "Falha ao inserir horario!";
                }
               
            }
            ?>


            <div class="lista-horarios" id="lista-horarios">
                <?php 
                
                $horarios = "
                SELECT nome,horario
                FROM horario_subiu INNER JOIN usuario ON usuario.nome = horario_subiu.usuario
                WHERE DATE(data_envio) = CURDATE();
                ";

                $resultado = mysqli_query($conexao,$horarios);

                if(mysqli_num_rows($resultado) > 0){

                    while($linha = mysqli_fetch_assoc($resultado)){
                        echo "<p id = \"horario\"><span class = \"destaque\">".$linha['nome']."</span> foi jogar às <span class = \"destaque\">".$linha['horario']."</span> horas.</p>";
                    }
                }
                
                ?>
            </div>
        </div>

        <div class="main-row">
            <div class="box">
                <h2>Chat Rápido</h2>
                <label for="nome-chat-select">Quem está enviando a mensagem:</label>

                <p class = "destaque"><?php echo $usuario_logado;?></p>

             <form action="" method = "post">

            <input type="text" id="mensagem" name = "mensagem" placeholder="Digite sua mensagem">
            <button type = "submit">Enviar</button>

            </form>
            

            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mensagem'])){

                $msg = $_POST['mensagem'];
                
                $inserirMsg = "
                INSERT INTO chat(usuario,mensagem) VALUES('$usuario_logado','$msg');
                ";

                $resulta = mysqli_query($conexao,$inserirMsg);

                if(!$resulta){
                    echo "Falha ao enviar mensagem!";
                }
                
            }
            ?>
                
                <div class="chat-box-inner" id="chat">
                
                <?php 
                /*
                $mensagem = "
                SELECT nome,mensagem,data_envio
                FROM chat INNER JOIN usuario ON usuario.nome = chat.usuario
                WHERE DATE(data_envio) = CURDATE();
                ";

                $resultados = mysqli_query($conexao,$mensagem);

                if(mysqli_num_rows($resultados) > 0){

                    while($tupla= mysqli_fetch_assoc($resultados)){
                        $dataEnvio = date('H:i', strtotime($tupla['data_envio']));
                        echo "<p id = \"mensagem\"><span class = \"destaque\">[".$dataEnvio."] ".$tupla['nome']." :</span> ".$tupla['mensagem']."</p>";
                    }
                }
                */
                ?>
                </div>
                <div class="footer">As mensagens serão apagadas no dia seguinte.</div>
            </div>

            <div class="box">
                <h2>Ranking de Jogadores</h2>
                <div class="ranking-table" id="ranking">
                    <div class='item-horario'>Funcionalidade de Ranking não implementada nesta versão.</div>
                </div>
            </div>

        </div>
    </div>

    <footer class="footer">⚽ Site da pelada, só os cria</footer>
    
    <script>
        // Função que usa AJAX para buscar e atualizar as mensagens
        function atualizarChat() {
            // Cria um novo objeto XMLHttpRequest
            var xhr = new XMLHttpRequest();
            
            // Define o que fazer quando a resposta do servidor chegar
            xhr.onreadystatechange = function() {
                // Checa se a requisição foi concluída (readyState 4) e bem-sucedida (status 200)
                if (this.readyState == 4 && this.status == 200) {
                    // Atualiza o conteúdo da div 'chat' (a caixa interna) com o HTML recebido
                    document.getElementById("chat").innerHTML = this.responseText;
                    
                    // Opcional: Fazer o scroll automático para a última mensagem
                    var chatBox = document.getElementById("chat");
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            };
            
            // Abre a requisição: GET para o novo arquivo PHP
            xhr.open("GET", "fetch_messages.php", true);
            
            // Envia a requisição
            xhr.send();
        }

        // 1. Chama a função uma vez para carregar as mensagens imediatamente
        atualizarChat();

        // 2. Define um intervalo de tempo para chamar a função automaticamente
        // 1000 milissegundos = 1 segundos. Altere este valor se quiser mais rápido ou mais lento.
        setInterval(atualizarChat, 1000); 
        
    </script>
</body>
</html>