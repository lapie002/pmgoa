<?php 

    require("config.php");
    $date = getdate();
    
    $sgbd = new PDO("mysql:host={$_SGBD["host"]};dbname={$_SGBD["dbname"]};charset={$_SGBD["charset"]}",$_SGBD["id"],$_SGBD["mdp"]);
   
   
    // I don't know if I should keep the quote 
   	$name = $sgbd->quote($_POST['name']);
	$phonenumber = $sgbd->quote($_POST['phonenumber']);
	$salesemail = $sgbd->quote($_POST['salesemail']);
	$artworkemail = $sgbd->quote($_POST['artworkemail']);
	$accountingemail = $sgbd->quote($_POST['accountingemail']);
	
	
	
	$req = "INSERT INTO pmgoa_vendors (name, phonenumber, salesemail, artworkemail, accountingemail)";
    $req  = $req." VALUES ($name,$phonenumber,$salesemail,$artworkemail,$accountingemail);";
	
    $result  = $sgbd->query($req);
    
    
    //print_r($_FILES);
    
     if ($result == false)
	{
		
		echo "<p>Error: failed to submit !!! $req</p>";
		echo '<p></p>';
		echo '<p><a href="#####">Home Page !!!</a></p>';
		
	}
	
	else{
		
		$id=$sgbd->lastInsertId();
		
		// soit avec ou sans le .pdf a voir !!!
		$target_w9from_dir = "w9form/$id.pdf";
		$target_taxexemptionfrom_dir = "taxexemptionfrom/$id.pdf";
		$target_termsrequestform_dir = "termsrequestform/$id.pdf";
		
		//$target_file_w9form = $target_w9from_dir . basename($_FILES["w9form"]["name"]);
		//$target_file_tax = $target_taxexemptionfrom_dir . basename($_FILES["taxexemptionform"]["name"]);
		//$target_file_term = $target_termsrequestform_dir . basename($_FILES["termsrequestfrom"]["name"]);
		
		$target_file_w9form = $target_w9from_dir;
		$target_file_tax = $target_taxexemptionfrom_dir;
		$target_file_term = $target_termsrequestform_dir;
		
		$uploadOk = 1;
		
		$w9formFileType = pathinfo($target_file_w9form,PATHINFO_EXTENSION);
		$taxFileType = pathinfo($target_file_tax,PATHINFO_EXTENSION);
		$termFileType = pathinfo($target_file_term,PATHINFO_EXTENSION);
		
		//check if files already exist
		/*
		if (file_exists($target_file_w9form) && file_exists($target_file_tax) && file_exists($target_file_term))
		{
			echo "Sorry, your files already exist.";
			$uploadOk = 0;
		}
		*/
		
		// allow certain file format
		if($w9formFileType != "pdf" && $w9formFileType!= "jpg" && $w9formFileType!= "png")
		{
			echo "sorry, only JPG, PDF OR WORD Documents are allowed.";
			$uploadOk = 0;
		}
		
		if($uploadOk == 0)
		{
			echo "Sorry you files were not uploaded";
		}
		
		else
		{
			if (move_uploaded_file($_FILES["w9form"]["tmp_name"], $target_file_w9form))
			{
					echo "The file ". basename( $_FILES["w9form"]["name"]). " has been uploaded.";
			}
			
			if (move_uploaded_file($_FILES["taxexemptionform"]["tmp_name"], $target_file_tax))
			{
					echo "The file ". basename( $_FILES["taxexemptionform"]["name"]). " has been uploaded.";
			} 
			
			if (move_uploaded_file($_FILES["termsrequestfrom"]["tmp_name"], $target_file_term))
			{
					echo "The file ". basename( $_FILES["termsrequestfrom"]["name"]). " has been uploaded.";
			} 
			
			else 
			{
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
		
		
		
		
		//if(move_uploaded_file($_FILES["photo"]["tmp_name"],"photos/$id.png"))
		
		// $_FILES["file"]["type"] == "application/pdf"
		
		
	
	
    }
   
   
 ?>