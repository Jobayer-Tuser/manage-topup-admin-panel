<?php

namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class ExcelReaderController
{
    public function read()
    {

        $spreadsheet = $reader->load("test.xlsx");

        $d=$spreadsheet->getSheet(0)->toArray();

        echo count($d);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $i=1;
        unset($sheetData[0]);

        foreach ($sheetData as $t) {
            // process element here;

            echo $i."---".$t[0].",".$t[1]." <br>";
            $i++;
        }



        $reader = new Xlsx();
        //Read the excel file using the load() function. Here test.xlsx is the file name.
        $spreadsheet = $reader->load("test.xlsx");
        //Get the first sheet in the Excel file and convert it to an array using the toArray() function. And Get the Number of rows in the sheet using the count() function.
        $d=$spreadsheet->getSheet(0)->toArray();
        echo count($d);

        //If you want to iterate all the rows in the excel file, then first convert it to an array and iterate using for or foreach.
        $i=1;

//If you want to remove the first row(column header), use the unset() function.
        unset($sheetData[0]);

        foreach ($sheetData as $t) {
            // process element here;
// access column by index
            echo $i."---".$t[0].",".$t[1]." <br>";
            $i++;
        }

        //Get the sheet count using the getSheetCount() function.

        echo $spreadsheet->getSheetCount();

        #While the getSheetNames() method will return a list of all worksheets in the workbook, indexed by the order in which their “tabs” would appear when opened in MS Excel (or other appropriate Spreadsheet programs).

        echo $spreadsheet->getSheetNames();

        #Individual worksheets can be accessed by name, or by their index position in the workbook.

        // Get the second sheet in the workbook
        // Note that sheets are indexed from 0 $sheet = $spreadsheet->getSheet(1);//or
        // Retrieve the worksheet called 'Worksheet 1' $sheet = $spreadsheet->getSheetByName('Worksheet 1');

    }

    public function upload()
    {
        if (isset($_POST["import"])) {

            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'text/xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (in_array($_FILES["file"]["type"], $allowedFileType)) {

                $targetPath = 'uploads/' . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

                $Reader = new Xlsx();

                $spreadSheet = $Reader->load($targetPath);
                $excelSheet = $spreadSheet->getActiveSheet();
                $spreadSheetAry = $excelSheet->toArray();
                $sheetCount = count($spreadSheetAry);

                for ($i = 0; $i <= $sheetCount; $i ++) {
                    $name = "";
                    if (isset($spreadSheetAry[$i][0])) {
                        $name = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
                    }
                    $description = "";
                    if (isset($spreadSheetAry[$i][1])) {
                        $description = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
                    }

                    if (! empty($name) || ! empty($description)) {
                        $query = "insert into tbl_info(name,description) values(?,?)";
                        $paramType = "ss";
                        $paramArray = array(
                            $name,
                            $description
                        );
                        $insertId = $db->insert($query, $paramType, $paramArray);
                        // $query = "insert into tbl_info(name,description) values('" . $name . "','" . $description . "')";
                        // $result = mysqli_query($conn, $query);

                        if (! empty($insertId)) {
                            $type = "success";
                            $message = "Excel Data Imported into the Database";
                        } else {
                            $type = "error";
                            $message = "Problem in Importing Excel Data";
                        }
                    }
                }
            } else {
                $type = "error";
                $message = "Invalid File Type. Upload Excel File.";
            }
        }
    }

    public function readCSV()
    {
        if(isset($_POST["submit_file"]))
        {
            $file = $_FILES["file"]["tmp_name"];
            $file_open = fopen($file,"r");
            while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
            {
                $name = $csv[0];
                $age = $csv[1];
                $country = $csv[2];
                mysql_query("INSERT INTO employee VALUES ('$name','$age','country')");
            }
        }
    }
}