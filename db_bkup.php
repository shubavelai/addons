<?php
    $conn = new mysqli('localhost','root','','database_name');
    $data = '';
    $result = mysqli_query($conn,"SHOW TABLES");
    while($row = mysqli_fetch_row($result))
        $tables[] =  ($row[0]);
    foreach($tables as $table){
        $select = "SELECT * FROM `$table`";
        $result = $conn->query($select);
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $data .= json_encode(base64_encode(serialize($row)))."<br>";
            }
        }
    }

// Save the SQL script to a backup file
    $backup_file_name = 'bkup_file_name.xtn';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $data);
    fclose($fileHandler);

// Move saved back file into folder
    $path = "destination/folder/".$backup_file_name;
    if (copy($backup_file_name,$path)) 
    {
      unlink($backup_file_name);
    }
?>
