<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include 'conexao.php';
        session_start();

        $usuario = $_POST["usuario"];
        $senha   = $_POST["senha"];

        $sql = "
        SELECT nome
        FROM usuario
        WHERE nome = '$usuario' AND senha = '$senha';
        ";

        $resultado = mysqli_query($conexao,$sql);

        if(mysqli_num_rows($resultado) > 0){
            $_SESSION['usuario'] = $usuario;
            mysqli_close($conexao);
            header("Location:index.php");
            exit();
        }
        else{
          $verificaUser= "
           SELECT nome
           FROM usuario
           WHERE nome = '$usuario';
          ";

          $result= mysqli_query($conexao,$verificaUser);

         if(mysqli_num_rows($result) > 0){
            $erroUsuario = "Já existe um usuário com esse nome cadastrado!";
         }

         else{

            $inserir = "
            INSERT INTO usuario (nome,senha,data_criacao) VALUES ('$usuario','$senha', CURRENT_TIMESTAMP) ;
            ";

            $result = mysqli_query($conexao,$inserir);

            if($result){
                $_SESSION['usuario'] = $usuario;
                mysqli_close($conexao);
                header("Location:index.php");
                exit();
            }
          }
        }
    }
    ?>
    
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - CDF</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
      }

      body {
        background: #121212;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        padding: 20px;
      }

      .login-box {
        background: #1e1e1e;
        width: 100%;
        max-width: 350px;
        padding: 25px;
        border-radius: 6px;
        box-shadow: 0 0 10px #000;
      }

      h1 {
        text-align: center;
        color: #ffd700;
        margin-bottom: 15px;
        font-size: 32px;
      }

      .subtitle {
        text-align: center;
        font-size: 14px;
        color: #bbb;
        margin-bottom: 20px;
      }

      label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
      }

      input {
        width: 100%;
        padding: 10px;
        background: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        margin-bottom: 12px;
      }

      button {
        width: 100%;
        padding: 10px;
        background: #0f7b34;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        transition: 0.2s;
      }

      button:hover {
        background: #159245;
      }

      p{
        margin-bottom:15px;
        color: #ff0000ff;
        font-weight: bold;
        font-size:12px;

      }

      .footer {
        margin-top: 10px;
        text-align: center;
        font-size: 12px;
        color: #999;
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
    <form class="login-box" method = "post" action="">
      <h1>CDF</h1>
      <p class="subtitle">Crias do Futebol</p>

      <label>Nome de usuário:</label>
      <input type="text" name="usuario" placeholder="Usuario" required />

      <label>Senha:</label>
      <input
        type="password"
        name="senha"
        placeholder="Digite sua senha"
        required
      />

      
      <?php 
      echo "<p>".($erroUsuario ?? '')."</p>";
      ?>
      <button type="submit">Entrar</button>

      <p class="footer">Se não tiver conta, ela será criada automaticamente.</p>
    </form>

  </body>
</html>