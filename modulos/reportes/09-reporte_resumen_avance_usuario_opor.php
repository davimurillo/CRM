<?php require_once('common.php'); checkUser();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Apices | CRM</title>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../lib/css/bootstrap.min.css" >
	<link rel="stylesheet" href="../../lib/css/animate.css" >
	<link href="../../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	<link id="switcher" href="../../lib/css/theme-color/lite-blue-theme.css" rel="stylesheet">
	  
	   <!-- Main Style -->
    <link href="../../style.css" rel="stylesheet">
	
	

</head>

<body>
<div class="container">
<?php require_once('cfg_cabecera.php'); ?>


<div id="dvData" style="margin-top:50px">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="print" align="left" ><h3>RESUMEN DE AVANCE DE OPORTUNIDADES POR USUARIO</h3><hr></div>

<div  align="center"  class="col-lg-8 col-md-8 col-sm-8 col-xs-8"  style="margin-top:10px; text-align:center">
<canvas  id="mybarChart"></canvas>
                
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px">
<table class="table table-bordered" style="font-size:12px; width:100%" >
  
  <tr class="active">
    <th  style="text-align:center">USUARIO</th>
    <th  style="text-align:center">EMPRESA</th>
    <th  style="text-align:center">SERVICIO</th>
    <th style="text-align:center">N° Oportunidad<br>A tiempo</th>
    <th style="text-align:center">N° Oportunidad<br>A Destiempo</th>
	 <th style="text-align:center">Total N° Oportunidad</th>
  </tr>
  
 
  <?php 
   $sql="SELECT tx_nombre_apellido, tx_nombre, tx_tipo_servicio, (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo<=nu_tiempo_avance and id_usuario=a.id_usuario and id_empresa=a.id_empresa AND tx_tipo_servicio=a.tx_tipo_servicio  ) AS a_tiempo, (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo>=nu_tiempo_avance and id_usuario=a.id_usuario and id_empresa=a.id_empresa AND tx_tipo_servicio=a.tx_tipo_servicio  ) AS a_destiempo,  (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE id_usuario=a.id_usuario and id_empresa=a.id_empresa AND tx_tipo_servicio=a.tx_tipo_servicio and ((nu_tiempo<=nu_tiempo_avance) or (nu_tiempo>=nu_tiempo_avance)) ) as total FROM vie_seguimiento_control_oportunidad a  GROUP BY id_usuario,id_empresa,tx_tipo_servicio,  tx_nombre, tx_nombre_apellido ORDER BY tx_nombre_apellido";
  $c=0;
  $total=0;
  $total_avanzada=0;
  $total_finalizadas=0;
  $data="";
  $data_bar="";
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	$c+=1;  
	?>
	<?php 
	
	$data.=' {
        label: "'.$row['tx_nombre_apellido'].'",
        backgroundColor: "rgba(0,102,153, 0.2)",
        borderColor: "rgba(0,102,153, 0.80)",
        pointBorderColor: "rgba(0,102,153, 0.80)",
        pointBackgroundColor: "rgba(0,102,153, 0.80)",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "rgba(0,102,153,1)",
        data: ['.$row['a_tiempo'].', '.$row['a_destiempo'].']
      },';
	  
	  $data_bar.='{
          label: "'.$row['tx_nombre_apellido'].'",
          backgroundColor:#006699,
          data: ['.$row['a_tiempo'].', '.$row['a_destiempo'].']
        },';
	?>
  <tr>
	<td  ><?php echo $row['tx_nombre_apellido']; ?> </td>
    <td  ><?php echo $row['tx_nombre']; ?> </td>
    <td  ><?php echo $row['tx_tipo_servicio']; ?> </td>
    <td style="text-align:center"><?php echo $row['a_tiempo']; $total_avanzada+=$row['a_tiempo']; ?></td>
    <td style="text-align:center"><?php echo $row['a_destiempo']; $total_finalizadas+=$row['a_destiempo']; ?></td>
    <td style="text-align:center"><?php echo $row['a_tiempo']+$row['a_destiempo']; $total+=$row['a_tiempo']+$row['a_destiempo']; ?></td>
	
  </tr>
  <?php } ?>
   <tr class="active">
    <th  >Totales</th>
    <th  ></th>
    <th  ></th>
  
    <th style="text-align:center"><?php echo $total_avanzada; ?></th>
     <th style="text-align:center"><?php echo $total_finalizadas; ?></th>
     <th style="text-align:center"><?php echo $total; ?></th>
  </tr>
</table>
</div>
</div>
</div>
<script src="../../lib/js/jquery.1.6.1.js"></script>
<script src="../../lib/js/moment/moment.min.js"></script>
  <script src="../../lib/js/chartjs/chart.min.js"></script>

<script>
    Chart.defaults.global.legend = {
      enabled: true
    };
	 /*
	 // Radar chart
    var ctx = document.getElementById("canvasRadar");
    var data = {
      labels: ["A Tiempo", "A Destiempo"],
      datasets: [<?php echo $data; ?>]
    };
	
	 var canvasRadar = new Chart(ctx, {
      type: 'radar',
      data: data,
    });
	*/
	// Bar chart
    var ctx = document.getElementById("mybarChart");
    var mybarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["A Tiempo", "A Destiempo"],
        datasets: [<?php echo $data; ?>]
      },

      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

	
$(document).ready(function()
{
	$("#printer").click(function ()
	{
		$('#cabecera').hide();
		window.print();
		$('#cabecera').show();
	});
	
	
	$("#exportar").click(function (e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));
    e.preventDefault();
	});
	
	
});
</script>
</body>
</html>