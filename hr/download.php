<?php
require 'vendor/autoload.php'; // Include the PHPWord autoloader

// Create a new PHPWord object
$phpWord = new \PhpOffice\PhpWord\PhpWord();

// Add a new section to the PHPWord object
$section = $phpWord->addSection();

// Add content to the section
$title = $_POST['title'];
$description = $_POST['description'];
$data = $_POST['data'];

// Set the title and description in the document
$section->addText($title, ['bold' => true, 'size' => 16]);
$section->addText($description, ['italic' => true]);

// Add the JSON data to the document
$section->addText("Data (JSON format):");
$section->addText($data);

// Save the PHPWord object as a DOCX file
$filename = "JSON.docx";
$phpWord->save($filename);

// Set appropriate headers for file download
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . filesize($filename));

// Serve the generated DOCX file
readfile($filename);

// Remove the generated file
unlink($filename);
exit;
?>
