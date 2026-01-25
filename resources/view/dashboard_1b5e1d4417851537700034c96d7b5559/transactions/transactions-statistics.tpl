
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="card">

      <div class="card-body" >
        <div class="transactions-statistics-month-list mb-3" >
           <div class="transactions-statistics-month-list-item dropdown-toggle" data-bs-toggle="dropdown" >
             <strong>{{ translate("tr_2d0847acdd5b752ae22779ebca3b60c5") }}</strong>
             <span>{{ $_POST["year"]?:$template->datetime->currentYear(); }}</span>
           </div>
           
           <ul class="dropdown-menu dropdown-menu-start" style="max-height: 250px; overflow: auto;">
            {{ $template->component->transaction->outStatisticsListYears($_POST["year"]); }}
           </ul>

          {{ $template->component->transaction->outStatisticsListProfitByMonth($_POST["month"],$_POST["year"]); }}                    
        </div>
      </div>

      <div id="fullTransactionsStatistics" ></div>

      <input type="hidden" name="month" value="{{ $_POST['month']?:$template->datetime->currentMonth(); }}" >
      <input type="hidden" name="year" value="{{ $_POST['year']?:$template->datetime->currentYear(); }}" >

    </div>

  </div>
</div>