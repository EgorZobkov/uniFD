<?php if($app->user->verificationAccess('view', 'dashboard-users')->status){ ?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements mb-4">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?></h5>
        <div class="card-title-elements ms-auto">
          <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-muted"></i></span>
          <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" >
              <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
            </div>
          </div>
        </div>
      </div>

    <div class="row mt-3">
      <div class="col-12 col-md-4 d-flex flex-column align-self-end">
        <div class="d-flex gap-2 align-items-center mb-0 pb-0 flex-wrap">
          <h1 class="mb-0"><?php echo $app->component->users->getTotalUsersToday(); ?></h1>
        </div>
        <small><?php echo translate("tr_2686bc1594db25a3d5f4ca1ec3e5460b"); ?></small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyUsersReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row gap-4 gap-sm-0">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsers(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_a00ecc5d266c29e56cfff153baf29302"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsersActive(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_424b82cc36184bb66b1a83ba77d5d0bd"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsersBlocked(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_aa7da6b6b0f9d367c8cd514ae6a19ead"); ?></p>
        </div>
      </div>
    </div>

    <div class="home-widget-javascript-container" >
    <script type="text/javascript">

    var helpers = new window.Helpers();

    var weeklyUsersReports = null;

    var weeklyUsersReportsConfig = {
      chart: {
        height: 210,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          barHeight: '60%',
          columnWidth: '38%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 4,
          distributed: true
        }
      },
      grid: {
        show: false,
        padding: {
          top: -30,
          bottom: 0,
          left: -10,
          right: -10
        }
      },
      colors: [
        '#7367f029',
        '#7367f029',
        '#7367f029',
        '#7367f029',
        '#7367f029',
        '#7367f029',
        '#7367f029'
      ],
      dataLabels: {
        enabled: false
      },
      series: [{
        data: <?php echo _json_encode($app->component->users->getTotalUsersByWeekChart()); ?>
      }],
      legend: {
        show: false
      },
      xaxis: {
        categories: [helpers.translate.content('Пн'), helpers.translate.content('Вт'), helpers.translate.content('Ср'), helpers.translate.content('Чт'), helpers.translate.content('Пт'), helpers.translate.content('Сб'), helpers.translate.content('Вс')],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: '#a5a3ae',
            fontSize: '13px',
          }
        }
      },
      tooltip: {
         custom: function({series, seriesIndex, dataPointIndex, w}) {
            var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
         
            return '<div class="apexcharts-tooltip-box" >'+data.title+'</div>';
         }
      },                       
      yaxis: {
        labels: {
          show: false,
        }
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 199
            }
          }
        }
      ]
    };

    weeklyUsersReports = new ApexCharts(document.querySelector('#weeklyUsersReports'), weeklyUsersReportsConfig);
    weeklyUsersReports.render();

    </script>
    </div>

    </div>
  </div>
</div>
<?php 

}else{

?>

<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements mb-4">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?></h5>
        <div class="card-title-elements ms-auto">
          <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-muted"></i></span>
          <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" >
              <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
            </div>
          </div>
        </div>
      </div>

      <?php echo $app->ui->wrapperInfo("dashboard-no-access-widget"); ?>      

    </div>
  </div>
</div>

<?php

}

?>
