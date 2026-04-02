<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<style>
body{margin:0;}
.sidebar{width:320px;height:100vh;background:#1e66d0;color:white;float:left;padding:20px;}
.content{margin-left:330px;padding:20px;}
.card{border-radius:20px;padding:20px;min-height:140px;cursor:pointer;}

.chart-box{
width:600px;height:350px;margin:40px auto;
display:none;background:white;padding:20px;
border-radius:15px;box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

.modal-backdrop.show{
backdrop-filter: blur(8px);
background: rgba(0,0,0,0.6);
}

.nav-btn{
width:40px;height:40px;border-radius:50%;
border:none;background:#0d6efd;color:white;
display:flex;align-items:center;justify-content:center;
font-size:18px;transition:0.3s;
}
.nav-btn:hover{background:#0b5ed7;transform:scale(1.1);}
</style>

</head>

<body>

<div class="sidebar">

<h4>Date</h4>

<form method="post" onsubmit="showLoader()">
From
<input type="date" name="from_date" value="<?= $from ?>" class="form-control">
To
<input type="date" name="to_date" value="<?= $to ?>" class="form-control">
<br>
<button class="btn btn-light w-100">Search</button>

<hr>

<h5>Chart Type</h5>
<select id="chartType" class="form-control" onchange="toggleChart()">
<option value="">Select Chart</option>
<option value="bar">Bar Chart</option>
<option value="pie">Pie Chart</option>
</select>

</form>
</div>

<div class="content">

<h3>Notifications</h3>

<div id="loader" style="display:none;text-align:center;">Loading...</div>

<?php
$email_success=0; $email_pending=0;
$whatsapp_success=0; $whatsapp_pending=0;
$sms_success=0; $sms_pending=0;
$web_success=0; $web_pending=0;
$push_success=0; $push_pending=0;

if(!empty($notifications)){
foreach($notifications as $n){
if(empty(trim($n->send_to))) continue;

if($n->type=="Email"){ $n->status==1 ? $email_success++ : $email_pending++; }
if($n->type=="Whatsapp"){ $n->status==1 ? $whatsapp_success++ : $whatsapp_pending++; }
if($n->type=="SMS"){ $n->status==1 ? $sms_success++ : $sms_pending++; }
if($n->type=="Web"){ $n->status==1 ? $web_success++ : $web_pending++; }
if($n->type=="Push"){ $n->status==1 ? $push_success++ : $push_pending++; }
}}

$total = $email_success+$email_pending+$whatsapp_success+$whatsapp_pending+$sms_success+$sms_pending+$web_success+$web_pending+$push_success+$push_pending;
$success = $email_success+$whatsapp_success+$sms_success+$web_success+$push_success;
?>

<!-- KPI -->
<div class="row text-center mb-4">
<div class="col-md-3"><div class="card bg-primary text-white shadow"><h5>Total</h5><h2><?= $total ?></h2></div></div>
<div class="col-md-3"><div class="card bg-success text-white shadow"><h5>Success</h5><h2><?= $success ?></h2></div></div>
<div class="col-md-3"><div class="card bg-danger text-white shadow"><h5>Pending</h5><h2><?= $total-$success ?></h2></div></div>
<div class="col-md-3"><div class="card bg-dark text-white shadow"><h5>Success %</h5><h2><?= $total ? round(($success/$total)*100)."%" : "0%" ?></h2></div></div>
</div>

<div class="row mt-4 g-4">

<?php
function card($type,$success,$pending,$class,$id,$notifications){
?>
<div class="col-md-4">
<div class="card <?= $class ?> shadow"
<?php if($pending > 0){ ?>
onclick="openModal('<?= $type ?>','<?= $id ?>')"
<?php } ?>>
<div class="card-body">
<?= $type ?><br>
Success : <?= $success ?><br>
Pending : <?= $pending ?>
</div>
</div>

<table id="<?= $id ?>Table" style="display:none;">
<?php foreach($notifications as $n){
if($n->type==$type && $n->status!=1 && !empty(trim($n->send_to))){ ?>
<tr>
<td><?= $n->send_to ?></td>
<td><?= date('d-m-Y H:i', strtotime($n->created_at)) ?></td>
<td><?= $n->error_status ?></td>
</tr>
<?php }} ?>
</table>
</div>
<?php } ?>

<?php
card("Email",$email_success,$email_pending,"","email",$notifications);
card("Whatsapp",$whatsapp_success,$whatsapp_pending,"bg-success text-white","whatsapp",$notifications);
card("SMS",$sms_success,$sms_pending,"bg-warning","sms",$notifications);
card("Web",$web_success,$web_pending,"bg-info text-white","web",$notifications);
card("Push",$push_success,$push_pending,"bg-dark text-white","push",$notifications);
?>

</div>

<!-- ✅ CHART BELOW -->
<div class="chart-box" id="chartContainer">
<canvas id="notificationChart"></canvas>
</div>

</div>

<!-- MODAL -->
<div class="modal fade" id="dataModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content rounded-4">

<div class="modal-header">
<h5 id="modalTitle"></h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="d-flex gap-2 mb-2">
<input type="text" id="modalSearch" class="form-control w-50" placeholder="Search...">

<button class="btn btn-success" onclick="exportExcel()"><i class="bi bi-file-earmark-excel"></i></button>
<button class="btn btn-danger" onclick="exportPDF('modalTable','Report')"><i class="bi bi-file-earmark-pdf"></i></button>
</div>

<table id="modalTable" class="table table-bordered">
<thead><tr><th>Contact</th><th>Date</th><th>Error</th></tr></thead>
<tbody id="modalTableBody"></tbody>
</table>

<div class="d-flex justify-content-center gap-3 mt-3">
<button id="prevBtn" class="nav-btn" onclick="prevPage()"><i class="bi bi-chevron-left"></i></button>
<button id="nextBtn" class="nav-btn" onclick="nextPage()"><i class="bi bi-chevron-right"></i></button>
</div>

</div>
</div>
</div>
</div>

<script>

function showLoader(){ document.getElementById("loader").style.display="block"; }

let modalStart=0, modalLimit=10;

function getFilteredRows(){
return Array.from(document.querySelectorAll("#modalTableBody tr"))
.filter(r=>r.dataset.match!=="false");
}

function showRows(){
let all=document.querySelectorAll("#modalTableBody tr");
let rows=getFilteredRows();
let total=rows.length;

all.forEach(r=>r.style.display="none");

rows.forEach((r,i)=>{
if(i>=modalStart && i<modalStart+modalLimit){ r.style.display=""; }
});

prevBtn.style.display = modalStart<=0?"none":"inline-flex";
nextBtn.style.display = (modalStart+modalLimit>=total)?"none":"inline-flex";
}

function nextPage(){ modalStart+=modalLimit; showRows(); }
function prevPage(){ modalStart-=modalLimit; if(modalStart<0)modalStart=0; showRows(); }

function openModal(type,id){
modalTitle.innerText=type+" Pending";
let tbody=modalTableBody;
tbody.innerHTML="";

document.querySelectorAll("#"+id+"Table tr").forEach(r=>{
let c=r.cloneNode(true);
c.dataset.match="true";
tbody.appendChild(c);
});

modalStart=0;

modalSearch.onkeyup=function(){
let v=this.value.toLowerCase();
document.querySelectorAll("#modalTableBody tr").forEach(r=>{
r.dataset.match = r.innerText.toLowerCase().includes(v)?"true":"false";
});
modalStart=0;
showRows();
};

showRows();
new bootstrap.Modal(dataModal).show();
}

function exportExcel(){
let rows=getFilteredRows();
let temp=document.createElement("table");

temp.innerHTML=`<tr><th>Contact</th><th>Date</th><th>Error</th></tr>`;

rows.forEach(r=>{
let c=r.cloneNode(true);
temp.appendChild(c);
});

let wb=XLSX.utils.table_to_book(temp);
XLSX.writeFile(wb,"Full_Data.xlsx");
}

function exportPDF(){
const { jsPDF } = window.jspdf;
let rows=getFilteredRows();
let body=[];

rows.forEach(r=>{
let td=r.querySelectorAll("td");
body.push([td[0]?.innerText,td[1]?.innerText,td[2]?.innerText]);
});

let doc=new jsPDF();
doc.text("Report",14,15);
doc.autoTable({head:[['Contact','Date','Error']],body,startY:20});
doc.save("Report.pdf");
}

// ✅ CHART WITH SAME COLORS
let chart;
function toggleChart(){

let type=chartType.value;
let box=chartContainer;

if(!type){ box.style.display="none"; return; }

box.style.display="block";
if(chart) chart.destroy();

let labels=['Email','Whatsapp','SMS','Web','Push'];
let ids=['email','whatsapp','sms','web','push'];

let colors=['#0d6efd','#198754','#ffc107','#0dcaf0','#212529'];

if(type==="pie"){
chart=new Chart(notificationChart,{
type:'doughnut',
data:{labels,datasets:[{data:[
<?= $email_success+$email_pending ?>,
<?= $whatsapp_success+$whatsapp_pending ?>,
<?= $sms_success+$sms_pending ?>,
<?= $web_success+$web_pending ?>,
<?= $push_success+$push_pending ?>
],backgroundColor:colors}]},
options:{onClick:(e,el)=>{if(el.length){openModal(labels[el[0].index],ids[el[0].index]);}}}
});
}else{
chart=new Chart(notificationChart,{
type:'bar',
data:{
labels,
datasets:[
{label:'Success',data:[<?= $email_success ?>,<?= $whatsapp_success ?>,<?= $sms_success ?>,<?= $web_success ?>,<?= $push_success ?>],backgroundColor:colors},
{label:'Pending',data:[<?= $email_pending ?>,<?= $whatsapp_pending ?>,<?= $sms_pending ?>,<?= $web_pending ?>,<?= $push_pending ?>],backgroundColor:'#dc3545'}
]
},
options:{onClick:(e,el)=>{if(el.length){openModal(labels[el[0].index],ids[el[0].index]);}}}
});
}

}

</script>

</body>
</html>