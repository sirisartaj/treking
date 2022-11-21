<?php

require_once  '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$stylesheet = '@import url(\'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap\');
body {
  width: 950px;
  height: 690px;
  left: 30px;
  top: 30px;
  border: 3px solid transparent;
  font-family: \'Montserrat\', sans-serif;
}
* {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
    color-adjust: exact !important;                 /*Firefox*/
}
html {
  display: inline-block;
  width: 1024px;
  height: 768px;
  background: #eee url("assets/images/certificate.jpg") no-repeat; background-size: 100%;
}
@media print {
* {-webkit-print-color-adjust:exact;}
body {-webkit-print-color-adjust: exact;}
body:before {
content:url(assets/images/certificate.jpg);
position: absolute;
z-index: -1;
}
}
@page {
    size:A4 landscape;
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 0px;
    margin-bottom: 0px;
    margin: 0;
    -webkit-print-color-adjust: exact;
}
h1 {
  margin: 5px 0px;
  font-size:46px;
  font-weight:600;
}
#cert-name{
text-align:center;
margin-top:330px;
}
.description{
margin-top:20px;
text-align:center;
font-size:25px;
font-weight:600;
float:left;
display:block;
}
.description p:nth-child(1) {
width:410px;
text-align:center;
float:left;
}
.description p:nth-child(2) {
width:100px;
text-align:center;
float:left;
}
.description p:nth-child(3) {
width:400px;
text-align:center;
float:left;
}
.description2{
margin-top:0px;
text-align:center;
font-size:20px;
font-weight:600;
float:left;
display:block;
}
.description2 p:nth-child(1) {
width:520px;
text-align:right;
float:left;
padding-right:75px;
margin-top:10px;
}
.description2 p:nth-child(2) {
width:100px;
text-align:center;
float:left;
font-size:16px;
}
.description2 p:nth-child(3) {
width:100px;
text-align:center;
float:left;
font-size:16px;
}';

$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML('<h1 id="cert-name"> Candidate Name </h1>
<div class="description"> <p>Hampta Pass</p> <p>A</p> <p>Hyderabad</p> </div>
<div class="description2"> <p>Text</p> <p>02nd Sep</p> <p>24th Sep</p> </div>',\Mpdf\HTMLParserMode::HTML_BODY);


$mpdf->Output();