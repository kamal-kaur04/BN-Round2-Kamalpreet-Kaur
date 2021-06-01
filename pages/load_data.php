<?php
 require_once 'config.php';
 $output = '';
 if(isset($_POST["dept_id"]))
 {
   //echo $_POST["dept_id"];
      if($_POST["dept_id"] != '')
      {
           if($_POST["dept_id"] == All){
             $dept = array("HR", "Manager", "Sales");
             foreach ($dept as $value) {
               $sql = "SELECT * FROM " .$value;
               echo $value;
               $output .= '<br><br><center><table style= "width:100%">
                           <tr class="tblrow" id="headers">
                                       <th>ID</th>
                                       <th>NAME</th>
                                       <th>SALARY</th>
                                       <th>PROFESSION</th>
                           </tr>';

             $result = mysqli_query($mysqli, $sql);

             while ($row = mysqli_fetch_array($result)) {
               $output .= '<tr><td> '. $row['id'] . '</td>
                           <td>' . $row['name'] . '</td>
                           <td>' . $row['salary'] . '</td>
                           <td>' . $row['profession'] . '</td></tr>';

             }
             $output .= '</table></center><br><br><br>';
             echo $output;
             $output = '';
             }
           } else if ($_POST["dept_id"] == HR || $_POST["dept_id"] == Manager || $_POST["dept_id"] == Sales ) {
             // code...
             echo $_POST["dept_id"];
             $sql = "SELECT * FROM " .$_POST["dept_id"];
             $output .= '<br><br><center><table style= "width:100%">
                         <tr class="tblrow" id="headers">
                                     <th>ID</th>
                                     <th>NAME</th>
                                     <th>SALARY</th>
                                     <th>PROFESSION</th>
                         </tr>';
              $result = mysqli_query($mysqli, $sql);

               while ($row = mysqli_fetch_array($result)) {
                 $output .= '<tr><td> '. $row['id'] . '</td>
                             <td>' . $row['name'] . '</td>
                             <td>' . $row['salary'] . '</td>
                             <td>' . $row['profession'] . '</td></tr>';

               }
               $output .= '</table></center>';
               echo $output;
           }
         }
            else {
           echo " ";
      }
}
 ?>
