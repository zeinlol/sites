<?php die("Access Denied"); ?>#x#a:2:{s:6:"output";s:0:"";s:6:"result";a:2:{s:6:"report";a:0:{}s:2:"js";s:1391:"
  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'Orders', 'Total Items sold', 'Revenue net'], ['2016-06-21', 0,0,0], ['2016-06-22', 0,0,0], ['2016-06-23', 0,0,0], ['2016-06-24', 0,0,0], ['2016-06-25', 0,0,0], ['2016-06-26', 0,0,0], ['2016-06-27', 0,0,0], ['2016-06-28', 0,0,0], ['2016-06-29', 0,0,0], ['2016-06-30', 0,0,0], ['2016-07-01', 0,0,0], ['2016-07-02', 0,0,0], ['2016-07-03', 0,0,0], ['2016-07-04', 0,0,0], ['2016-07-05', 0,0,0], ['2016-07-06', 0,0,0], ['2016-07-07', 0,0,0], ['2016-07-08', 0,0,0], ['2016-07-09', 0,0,0], ['2016-07-10', 0,0,0], ['2016-07-11', 0,0,0], ['2016-07-12', 0,0,0], ['2016-07-13', 0,0,0], ['2016-07-14', 0,0,0], ['2016-07-15', 0,0,0], ['2016-07-16', 0,0,0], ['2016-07-17', 0,0,0], ['2016-07-18', 0,0,0], ['2016-07-19', 0,0,0]  ]);
        var options = {
          title: 'Report for the period from 21.06.2016 to 20.07.2016',
            series: {0: {targetAxisIndex:0},
                   1:{targetAxisIndex:0},
                   2:{targetAxisIndex:1},
                  },
                  colors: ["#00A1DF", "#A4CA37","#E66A0A"],
        };

        var chart = new google.visualization.LineChart(document.getElementById('vm_stats_chart'));

        chart.draw(data, options);
      }
";}}