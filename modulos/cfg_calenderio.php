<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Calendario del Sistema </title>

  <!-- Bootstrap core CSS -->

  <link href="../lib/css/bootstrap.min.css" rel="stylesheet">

  <link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="../lib/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="../lib/css/custom.css" rel="stylesheet">
  <link href="../lib/css/icheck/flat/green.css" rel="stylesheet">

  <link href="../lib/css/calendar/fullcalendar.css" rel="stylesheet">
  <link href="../lib/css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">

  <script src="../lib/js/jquery.min.js"></script>

  <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
            <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

</head>
<?php require_once('common.php'); checkUser(); 

		$sql="SELECT tx_valor FROM cfg_parametro WHERE id_parametro=1";
		$res=abredatabase(g_BaseDatos,$sql);
		$row=dregistro($res);

date_default_timezone_set($row['tx_valor']);
?>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" style="margin-top:10px">
		<div class="col-lg-6 col-md-6 col-sm-6 col-sx-6">
		
		<?php $sql="SELECT id_calendario,fe_calendario, tx_dia, in_nohabil FROM cfg_calendario WHERE fe_calendario >= '2017-01-01'";
		$res=abredatabase(g_BaseDatos,$sql); 	
		$row=dregistro($res);
		echo $fecha=date($row['fe_calendario']);
			echo date("Y", strtotime($row['fe_calendario']))."<br>";  
			echo date("m", strtotime($row['fe_calendario']))."<br>";  
			echo date("d", strtotime($row['fe_calendario']))."<br>"; 
		?>
		
		
		
		Año Calendario <select id="ano_calendario">
			<option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
		</select>
		</div>
	</div>

      <!-- top navigation -->
      

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="page-title">
            <div class="title_left">
              <h3>
                                    Calender
                                    <small>
                                        Click to add/edit events
                                    </small>
                                </h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Go!</button>
                                        </span>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Calenderio </h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div id='calendar'></div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="copyright-info">
            <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>


      <!-- Start Calender modal -->
      <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">New Calender Entry</h4>
            </div>
            <div class="modal-body">
              <div id="testmodal" style="padding: 5px 20px;">
                <form id="antoform" class="form-horizontal calender" role="form">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Title</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="title" name="title">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary antosubmit">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel2">Edit Calender Entry</h4>
            </div>
            <div class="modal-body">

              <div id="testmodal2" style="padding: 5px 20px;">
                <form id="antoform2" class="form-horizontal calender" role="form">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Title</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="title2" name="title2">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
      <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>

      <!-- End Calender modal -->
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="../lib/js/bootstrap.min.js"></script>

  <script src="../lib/js/nprogress.js"></script>
  
  <!-- bootstrap progress js -->
  <script src="../lib/js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../lib/js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="../lib/js/icheck/icheck.min.js"></script>

  <script src="../lib/js/custom.js"></script>

  <script src="../lib/js/moment/moment.min.js"></script>
  <script src="../lib/js/calendar/fullcalendar.min.js"></script>
  <!-- pace -->
  <script src="../lib/js/pace/pace.min.js"></script>
  <script>
    $(window).load(function() {

      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();
      var started;
      var categoryClass;

      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
          $('#fc_create').click();

          started = start;
          ended = end

          $(".antosubmit").on("click", function() {
            var title = $("#title").val();
            if (end) {
              ended = end
            }
            categoryClass = $("#event_type").val();

            if (title) {
              calendar.fullCalendar('renderEvent', {
                  title: title,
                  start: started,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            $('#title').val('');
            calendar.fullCalendar('unselect');

            $('.antoclose').click();

            return false;
          });
        },
        eventClick: function(calEvent, jsEvent, view) {
          //alert(calEvent.title, jsEvent, view);

          $('#fc_edit').click();
          $('#title2').val(calEvent.title);
          categoryClass = $("#event_type").val();

          $(".antosubmit2").on("click", function() {
            calEvent.title = $("#title2").val();

            calendar.fullCalendar('updateEvent', calEvent);
            $('.antoclose2').click();
          });
          calendar.fullCalendar('unselect');
        },
        editable: true,
        events: [
		<?php $sql="SELECT id_calendario,fe_calendario, tx_dia, in_nohabil FROM cfg_calendario WHERE fe_calendario >= '2017-04-01' and in_nohabil=true"; ?>
		<?php $res=abredatabase(g_BaseDatos,$sql); 	while ($row=dregistro($res)){?>
		{
          title: 'Falso',
          start: new Date(<?php echo date("Y", strtotime($row['fe_calendario'])); ?>, <?php echo date("m", strtotime($row['fe_calendario'])); ?>, <?php echo date("d", strtotime($row['fe_calendario'])); ?>)
        },
		<?php } ?>
		]
      });
    });
  </script>
</body>

</html>
