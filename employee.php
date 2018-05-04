<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('display_errors', 1);



$xml=new DOMDocument("1.0","UTF-8");
$xml->load('employee.xml');

//search

$id_g=12;
$id_search="";
$name_search="";
$salary_search="";

$xpath=new DOMXPath($xml);


foreach($xpath->query("/employees/employee[id='1']") as $node)
  {
   $id_search=$node->childNodes['']->nextSibling->nodeValue;
   $name_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nodeValue;
   $salary_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue;
  }

if(isset($_POST['Search'])&& $_POST['Search']){

  $to_search=$_POST['search_id'];
  //echo $to_search;
  if($to_search)
  {
  $xpath=new DOMXPath($xml);
  foreach($xpath->query("/employees/employee[id=$to_search]") as $node)
    {
      echo $node->childNodes['']->nodeValue;
     $id_search=$node->childNodes['']->nextSibling->nodeValue;
     $name_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nodeValue;
     $salary_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue;
    }
  }
}

//next
if(isset($_POST['next']) && $_POST['next']){
$to_search=$_POST['id'];
$id_next=$to_search+1;
$find=false;
while(! $find && ($id_next <= $id_g))
{
if($id_next > $to_search)
{
foreach($xpath->query("/employees/employee[id=$id_next]") as $node)
  {   $find=true;
      if(isset($node->childNodes['']->nextSibling->nodeValue))
      {
           $id_search=$node->childNodes['']->nextSibling->nodeValue;
      }
      if(isset($node->childNodes['']->nextSibling->nextSibling->nextSibling->nodeValue ))
      {
        $name_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nodeValue;
      }
      if(isset($node->childNodes['']->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue))
      {
         $salary_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue;
      }
    }
  }
  $id_next++;
}
}


//prev
if(isset($_POST['previous'])&& $_POST['previous'])
{
$to_search=$_POST['id'];
$id_previous=$to_search-1;
$xpath=new DOMXPath($xml);
foreach($xpath->query("/employees/employee[id=$id_previous]") as $node)
  {
   $id_search=$node->childNodes['']->nextSibling->nodeValue;
   $name_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nodeValue;
   $salary_search=$node->childNodes['']->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue;
  }
}



//insert
if(isset($_POST['insert']) && $_POST['insert'])
{
  $xml=new DOMDocument("1.0","UTF-8");
   $xml->preserveWhiteSpace = false;
   $xml->formatOutput = true;
  $xml->load('employee.xml');
  $id=$_POST['id'];
  $salary=$_POST['salary'];
  $name=$_POST['name'];
  $rootTag=$xml->getElementsByTagName("employees")->item(0);
  $employee=$xml->createElement("employee");

  $id_tag=$xml->createElement("id",$id);
  $name_tag=$xml->createElement("name",$name);
  $salary_tag=$xml->createElement("salary",$salary);
  $id_g=$id;
  $employee->appendChild($id_tag);
  $employee->appendChild($name_tag);
  $employee->appendChild($salary_tag);
  $xml->formatOutput =true;
  $rootTag->appendChild($employee);
  $xml->save('employee.xml');
  $id_g+=1;
}


//delete
if(isset($_POST['delete']) && $_POST['delete'])
 {
  $id=$_POST['id'];
  $salary=$_POST['salary'];
  $name=$_POST['name'];
  $xpath=new DOMXPath($xml);
  foreach($xpath->query("/employees/employee[name='$name']") as $node)
  {
    $node->parentNode ->removeChild($node);
   }
 $xml->preserveWhiteSpace = false;
 $xml->formatoutput=true;

 $xml->save('employee.xml');

}
?>
<html>
  <head>
    <style>
    .border{
      border:1px solid black;
      background-color:#f0ff0f;
    }

    </style>
  </head>
    <body>
    <div align="center" class="border">
      <h1> Welcome </h1>
      <br/>
    <form method="POST" action="note.php">
      ID: <input type="number" name='id' value="<?php echo htmlspecialchars(isset($id_search) ==1)? $id_search:"";?>"> <br/><br/>
      Name:<input type="text" name='name' value="<?php echo htmlspecialchars(isset($name_search)==1)?$name_search:"";?>" > <br/><br/>
      Salary:<input type="number" name='salary' value="<?php echo htmlspecialchars(isset($salary_search)==1)?$salary_search:"";?>"><br/><br/>
      <input type="number" name="search_id" placeholder="Enter id to search">
      <input type="submit" name="Search" value="Search">
    </br>
    <br/>
      <input type="submit" name="insert" value="insert">
      <input type="submit" name="delete" value="Delete">
      <input type="submit" name="next" value="Next">
      <input type="submit" name="previous" value="Previous">
        </form>
      </div>
  </body>
</html>
