<?php
    global $i ;
    $i = 3 ;
    try
	{
		$user="root" ;
		$database_name="chat" ;

		$db_connect = new PDO("mysql:host=127.0.0.1;dbname=$database_name","$user","");
		$db_connect -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION) ;
        // echo 'Connection database is successfull <br> ' ;
    }
    catch( PDOException $e )
	{
		die('Erreur : ' .$e->getMessage()) ;
    }

    $task = "list" ;

    if(array_key_exists("task", $_GET)){
       $task = $_GET['task'];
    }
    if($task == 'write'){
        postMessage() ;
    }else{
        getMessage() ;
    }

    function getMessage(){
        global $db_connect;
        $select = "SELECT * FROM chatting";
        $resultat = $db_connect->prepare($select);
        $resultat->execute();
        $message = $resultat -> fetchAll();
        echo json_encode($message) ; 
    }

    function postMessage(){
        global $db_connect ;
        global $i ;
        if (!array_key_exists('author', $_POST) || !array_key_exists('content', $_POST)){
            echo json_encode(['status' => 'error' , 'message' => 'One field at least is not given']);
            return ;
        }

        $author = $_POST['author'] ;
        $content = $_POST['content'];
        // $query = $db_connect->prepare('INSERT INTO message SET id = :i , author = :author, creation_date = :creation_date)');
        // $query -> execute([
        //     'id' => $i ,
        //     'author' => $author,
        //     'creation_date' => $content,
        // ]);
        $query = $db_connect->prepare('INSERT INTO chatting VALUES(:author, :content, NOW());');
        $query->bindParam(':author', $author);
        $query->bindParam(':content', $content);
        // $query->bindParam(':creation_date', NOW());
        $query->execute() ;
        echo json_encode(['status' => 's uccess']);
        $i = $i + 1 ;
    }
?>
