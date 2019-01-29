<form method="POST" action="">
    <input type="text" name = "link"> 
    <input type="submit" name ="submit">
</form>

<?php
 
require "DB.php";

if($_POST['link'] == true && $_POST['submit'] == true){
    $stmt = $pdo->prepare("
    SELECT 
        * 
    FROM 
        `shortlink` 
    WHERE
        `link` = :link
    ");

    $stmt->execute(['link' => $_POST['link']]);

    

    $select = $stmt->fetchAll();
    var_dump($select);
    if($select == true){
        echo 'У вас уже есть сокращенный домен на этот url адресс';
    }else{
       

        function  GetShortKey(){ 
            $letters='QWERTYUIOPASDFGHJKLZXCVBNM1234567890';
            $count=strlen($letters);
            $intval=time();
            $result='';
            for($i=0;$i<4;$i++) {
                $last=$intval%$count;
                $intval=($intval-$last)/$count;
                $result.=$letters[$last];
            }   
            $result = '?key=yourdomen'.$result;
            
            global $pdo;
            $stmt = $pdo->prepare("
            SELECT 
                * 
            FROM 
                `shortlink` 
            WHERE
                `shortkey` = :key
            ");
        
            $stmt -> execute(['key' => $result]);

            $key = $stmt->fetchAll();   
            
            if($key){
                GetShortKey();
            }else{
                echo $result;
                return $result;
            }
        }
        

        $result1 = GetShortKey();
        $stmt = $pdo->prepare("
        INSERT INTO
            `shortlink` (
                `link`,
                `shortkey`
            ) VAlUES (
                :link,
                :shortkey
            )
    ");
    $stmt->execute([
        'link' => $_POST['link'],
        'shortkey' => $result1
        ]);
        
    }
             
}

