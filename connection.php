<?php

    $servername="localhost";
    $username="root";
    $password="1234";
    $dbname="egm_users";

    // Criar conexao
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Checar conexao
    if(!$conn){
        die("Conexao falhou: ".mysqli_connect_error());
    }

 ?>