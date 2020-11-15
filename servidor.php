<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: text/html; charset=utf-8");

include "Connect/connect.php";

$postjson = json_decode(file_get_contents('php://input'),true);



if($postjson['crud'] == 'listar'){

    $data = array();
    $query = mysqli_query($mysqli, "SELECT * FROM produtos ORDER BY id DESC");

    while($row = mysqli_fetch_array($query)){
        $data[] = array(
            'id'                         => $row['id'],
            'nome'                       => $row['nome'],
            'valor'                      => $row['valor'],
            'qtd'                        => $row['qtd']
            
        );
    }

    if($query) $result = json_encode(array('success' => true,'result' =>$data));
    else $result = json_encode(array('success'=> false));
    echo $result;

}


if($postjson['crud'] == 'listar-contador'){

    $data = array();
    $query = mysqli_query($mysqli, "SELECT * FROM pedidos ORDER BY id DESC");

    while($row = mysqli_fetch_array($query)){
        $data[] = array(
            'id'                         => $row['id'],
            'nome'                       => $row['nome'],
            'valor'                      => $row['valor'],
            'total'                      => $row['total'],
            'qtd'                        => $row['qtd']
            
        );
    }

    if($query) $result = json_encode(array('success' => true,'result' =>$data));
    else $result = json_encode(array('success'=> false));
    echo $result;

}


elseif($postjson['crud'] == 'listar-total'){

    $data = array();
    $query = mysqli_query($mysqli, "SELECT SUM(valor) as soma FROM pedidos ORDER BY id DESC");

    while($row = mysqli_fetch_array($query)){
        $data[] = array(

            
            'soma'                         => $row['soma']
            
        );
    }

    if($query) $result = json_encode(array('success' => true,'result' =>$data));
    else $result = json_encode(array('success'=> false));
    echo $result;

}


elseif($postjson['crud'] == 'add'){
  
    $qtd = $postjson["qtd"] + 1;
    $total = $qtd * $postjson["total"];
  
    $query   = mysqli_query($mysqli, "UPDATE pedidos SET
	           
               qtd      =  '$qtd',
               valor    =  '$total'
               
               WHERE id  = '$postjson[id]'");

    

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}

elseif($postjson['crud'] == 'rev'){
  
    $qtd = $postjson["qtd"];   
    $qtd2 = $postjson["qtd"] - 1;   
    $total = ($postjson["valor"] - $postjson["total"]);
  
    $query   = mysqli_query($mysqli, "UPDATE pedidos SET
	           
               qtd      =  '$qtd2',
               valor    =  '$total'
               
               WHERE id  = '$postjson[id]'");

    

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}

elseif($postjson['crud'] == 'add_item'){
    $data = array();

    $query   = mysqli_query($mysqli, "INSERT INTO cores_card SET
               cor          = '$postjson[cor]',
               qtd          = '$postjson[qtd]'
               

    ");

    $idadd = mysqli_insert_id($mysqli);

    if($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
    else $result = json_encode(array('success'=> false));
    echo $result;
}


    elseif($postjson['crud'] == 'editar'){
  
    $dateNow = date('Y-m_d');
  
    $query   = mysqli_query($mysqli, "UPDATE lojista SET
	           
               nome      =  '$postjson[nome]',
			   email     =  '$postjson[email]',
               telefone  =  '$postjson[telefone]',   
               categoria =  '$postjson[categoria]' WHERE id  = '$postjson[id]'");

    

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}


  elseif($postjson['crud'] == 'deletar'){
  
    $query   = mysqli_query($mysqli, "DELETE FROM lojista WHERE id  = '$postjson[id]'");
  

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}

	


?>