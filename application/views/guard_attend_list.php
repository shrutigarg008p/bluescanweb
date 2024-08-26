<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
                    <h2><?php echo $title; ?></h2>                    
                </div>
            <div class="panel panel-default">

                
               <div class="panel-heading">
                   <div class="searchpanel" style="padding: 20px;">
                 <div class="input-group pull-left" style="width: 20%" >
                    
                      <input placeholder="Daily Attendance" type="radio"
                        class="pull-left fitlerType" id="filterType1"
                        name="filterType" value="1" <?php if($filterType == 1){ echo 'checked="checked"';} ?>  />Daily Attendance
                      </div>
                      <div class="input-group pull-left" style="width: 20%" >
                      <input placeholder="Monthly Attendance" type="radio" 
                        class="pull-left fitlerType" id="filterType2"
                        name="filterType" value="2" <?php if($filterType == 2){ echo 'checked="checked"';} ?>   />Monthly Attendance
                      </div>
                      <div class="input-group pull-right" style="padding: 14px 0; width: 100%;" >
                      <input placeholder="Date" type="text" 
                        class="form-control datepicker pull-left" id="filterDate" name="filterDate" value="<?php echo $filterDate; ?>"
                        style="margin-right: 6px;vertical-align: middle; width: 365px; <?php if($filterType == 1){ echo 'display: block;'; }else{ echo 'display: none;'; }?>" />
                      <select name="filter_month" id="filter_month" class="pull-left" style="margin-right: 6px;vertical-align: middle; width: 182px; <?php if($filterType == 2){ echo 'display: block;'; }else{ echo 'display: none;'; }?>">
                          <option value="" >Select Month</option>
                          <?php for($mo=1;$mo<=12;$mo++){ 
                                    $modate = date('Y-'.$mo.'-d');
                              ?>
                              <option value="<?php echo date('m',strtotime($modate)); ?>" <?php if($filter_month == date('m',strtotime($modate))){ echo 'selected="selected"';} ?> ><?php echo date('F',strtotime($modate)); ?></option>
                       <?php   } ?>
                          
                      </select>
                      
                      <select name="filter_year" id="filter_year" class="pull-left" style="margin-right: 6px;vertical-align: middle; width: 183px; <?php if($filterType == 2){ echo 'display: block;'; }else{ echo 'display: none;'; }?>" >
                           <option value="" >Select Year</option>
                           <?php for($yo=2000;$yo<=date('Y');$yo++){ 
                              ?>
                              <option value="<?php echo $yo; ?>" <?php if($filter_year == $yo){ echo 'selected="selected"';} ?> ><?php echo $yo; ?></option>
                       <?php   } ?>
                          
                      </select>
                      <!--<select name="guard_desig" id="guard_desig" class="pull-left" style="margin-right: 6px;vertical-align: middle; width: 182px; <?php if($filterType == 2){ echo 'display: block;'; }else{ echo 'display: none;'; }?>">
                      <?php $designation=$this->config->item('experienceDesignationArr'); ?>
                          <option value="" >Select Guard Designation</option>
                          <?php foreach($designation as $data){ ?>
                              <option value="<?php echo $data; ?>" <?php if(!empty($guardAttData) && $guardAttData->designation==$data ){echo 'selected="selected"';}; ?> ><?php echo $data; ?></option>
                       <?php  } ?>
                          
                      </select>-->
                      <button class="btn btn-primary pull-left" style=" padding: 5px 15px;vertical-align: middle;">Go</button>
                      </div>
                      
                    </div>
                      
                       
                

                
                
                
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive">
                        <br/>
                        
                        
                        <table class="table table-bordered table-striped table-actions">
                        </table>
                        
                        <div id="container" style="height: 500px; min-width: 310px; max-width: 1000px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MANY COLUMNS  -->
</form>

    
</div>      
<script type="text/javascript" src="<?php echo site_url('js/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
var datearr = [];
var guardarr    = [];
var attendanceArr   = [];
<?php 
/*
for($l=0;$l<count($dateArr);$l++){ ?>
     datearr[parseInt('<?php echo $l; ?>')] = '<?php echo date('Y-m-d', strtotime($dateArr[$l]) ); ?>';
    <?php
}*/
if(count($guardAttData)>0){
        $guardArr = array();
        $dateArr  = array();
        $j = 0;
        $k = 0;
        for($i=0;$i<count($guardAttData);$i++){ 
            $color = ' style="color:#385a00;font-weight:bold;" ';
            if($guardAttData[$i]->attendance_type == 1){
                 $color = ' style="color:#ff0000;font-weight:bold;" ';
            }
            $date = date('Y-m-d', strtotime($guardAttData[$i]->attendance_date));
            ?>
                 
        <?php
            if(!in_array($guardAttData[$i]->guard_name,$guardArr)){ 
                  $guardArr[] = $guardAttData[$i]->guard_name; 
        ?>
          guardarr[parseInt('<?php echo $j; ?>')] = '<?php echo $guardAttData[$i]->guard_name; ?>'+' '+'(<?php echo $guardAttData[$i]->designation; ?>)';
 <?php          
            $j++;
            }
            
            if(!in_array($date,$dateArr)){ 
                $dateArr[] = date('Y-m-d', strtotime($guardAttData[$i]->attendance_date) );
        
        ?>
                datearr[parseInt('<?php echo $k; ?>')] = '<?php echo date('Y-m-d', strtotime($guardAttData[$i]->attendance_date) ); ?>';
 <?php          
            $k++;
            } 
            ?>
                var temp = [];
                temp = [parseInt('<?php echo array_search($date,$dateArr); ?>'),parseInt('<?php echo array_search ($guardAttData[$i]->guard_name,$guardArr); ?>'),'<span <?php echo $color; ?>  >P</span>'];
                if($.inArray(temp,attendanceArr) == -1){
                    attendanceArr[attendanceArr.length] = temp;
                }
                //console.log('date <?php echo $date.'>>>>>>>>>'.array_search ($date,$dateArr); ?>');
                //console.log('<?php echo  $guardAttData[$i]->guard_name.'>>>>>>>>>'.array_search ($guardAttData[$i]->guard_name,$guardArr); ?>');
 <?php                
        } //print_r($attendenceArr);die;
    }
       ?>
         // console.log(datearr); 
        //console.log(guardarr);        
       //console.log(attendanceArr);
    
$(function () {
    var chart = new Highcharts.Chart({

        chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 80,
            //plotBorderWidth: 1,
            renderTo: 'container'
        },


        title: {
            text: 'Guard Attendance'
        },

        xAxis: {
            categories: datearr,
             title: 'Date'
        },

        yAxis: {
            categories: guardarr,
            title: 'Guard Name'
        },

        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.yAxis.categories[this.point.y] + '</b><br><b>' +
                    '</b> present on <br><b>' +this.series.xAxis.categories[this.point.x];
            }
        },

        series: [{
            borderWidth: 1,
            allowPointSelect: false,
            data: attendanceArr,
            dataLabels: {
                enabled: true
            }
        }],
        lang: {
            noData: "No Data Found!"
        },
        noData: {
            style: {
                fontWeight: 'bold',
                fontSize: '15px',
                color: '#303030'
            }
        },
        credits: {
            enabled: false
        },
         plotOptions: {
            series: {
                borderColor: '#303030'
            }
        }

    });
    
    $(".fitlerType").click(function() {
        var filter = $('.fitlerType:checked').val();
        if(filter == 1){
            $('#filter_month').hide();
            $('#filter_year').hide();
             $('#filterDate').show();
        }else{
             $('#filter_month').show();
            $('#filter_year').show();
             $('#filter_month').val('');
            $('#filter_year').val('');
             $('#filterDate').hide();
        }
    });
});
</script>