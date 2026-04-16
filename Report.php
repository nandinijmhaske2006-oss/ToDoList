<?php 
require('fpdf/fpdf.php'); 
 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "php micro project"; 
 
// Create connection 
$conn = mysqli_connect($servername, $username, $password, $dbname); 
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); 
} 
 
// Fetch tasks 
$sql = "SELECT Id, task, status FROM tasks"; 
$result = mysqli_query($conn, $sql); 
 
$totalTasks = 0; 
$completedTasks = 0; 
$deletedTasks = 0; 
$remainingTasks = 0; 
$tasks = []; 
 
if ($result) { 
    while ($row = mysqli_fetch_assoc($result)) { 
        $tasks[] = $row; 
        $totalTasks++; 
        if ($row['status'] == 'completed') { 
            $completedTasks++; 
        } elseif ($row['status'] == 'deleted') { 
            $deletedTasks++; 
        } else { 
            $remainingTasks++; 
        } 
    } 
} 
 
mysqli_close($conn); 
 
class PDF extends FPDF { 
    function Header() { 
        $this->SetFillColor(100, 149, 237);  
        $this->Rect(0, 0, 210, 30, 'F'); 
 
        // Title 
        $this->SetFont('Arial', 'B', 16); 
        $this->SetTextColor(255, 255, 255); 
        $this->Cell(190, 20, 'To-Do List Report', 0, 1, 'C'); 
        $this->Ln(10); 
    } 
 
    function Footer() { 
        $this->SetY(-15); 
        $this->SetFont('Arial', 'I', 10); 
        $this->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s'), 0, 0, 'C'); 
    } 
} 
 
// Create PDF 
$pdf = new PDF(); 
$pdf->AddPage(); 
$pdf->SetFont('Arial', '', 12); 
 
$pdf->SetFillColor(240, 240, 240); 
$pdf->Cell(190, 8, "Task Summary", 0, 1, 'C', true); 
$pdf->Ln(2); 
 
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(50, 8, "Total Tasks: ", 0, 0); 
$pdf->SetFont('Arial', '', 12); 
$pdf->Cell(50, 8, $totalTasks, 0, 1); 
 
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(50, 8, "Completed Tasks: ", 0, 0); 
$pdf->SetFont('Arial', '', 12); 
$pdf->Cell(50, 8, $completedTasks, 0, 1); 
 
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(50, 8, "Deleted Tasks: ", 0, 0); 
$pdf->SetFont('Arial', '', 12); 
$pdf->Cell(50, 8, $deletedTasks, 0, 1); 
 
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(50, 8, "Remaining Tasks: ", 0, 0); 
$pdf->SetFont('Arial', '', 12); 
$pdf->Cell(50, 8, $remainingTasks, 0, 1); 
 
$pdf->Ln(5); 
 
$pdf->SetFillColor(100, 149, 237); 
$pdf->SetTextColor(255); 
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(30, 10, 'Task ID', 1, 0, 'C', true); 
$pdf->Cell(100, 10, 'Task Name', 1, 0, 'C', true); 
$pdf->Cell(50, 10, 'Status', 1, 1, 'C', true); 
 
$pdf->SetTextColor(0); 
$pdf->SetFont('Arial', '', 12); 
 
$fill = false; 
foreach ($tasks as $task) { 
    $pdf->SetFillColor(230, 230, 230); 
 
    // Task id 
    $pdf->Cell(30, 10, $task['Id'], 1, 0, 'C', $fill); 
 
    $pdf->Cell(100, 10, '', 1, 0, 'L', $fill);  
    $x = $pdf->GetX() - 100; 
    $y = $pdf->GetY(); 
    $pdf->SetXY($x, $y); 
    $pdf->MultiCell(100, 10, $task['task'], 0, 'L', $fill); 
    $pdf->SetXY($x + 100, $y); // Reset X position for next column 
 
     
    $pdf->Cell(50, 10, ucfirst($task['status']), 1, 1, 'C', $fill); 
 
    $fill = !$fill; 
} 
 
// Output the PDF 
$pdf->Output('D', 'TodoList_Report.pdf');  
?> 
