<script>
const labels = @json($allMonths);
const data = @json($chartData);

var barOptions = {
  series: [{
    name: "Transactions This Year",
    data: data
  }],
  chart: {
    type: "bar",
    height: 250,
    toolbar: { show: false }
  },

  colors: ['#AC7FF6'], 
  plotOptions: {
    bar: {
      borderRadius: 6,
      columnWidth: "40%",
      distributed: false,
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'light',
      type: "vertical",
      opacityFrom: 1,
      opacityTo: 0.8,
    }
  },
  xaxis: {
    categories: labels,
    axisBorder: { show: false },
    axisTicks: { show: false }
  },
  yaxis: {
    min: 0
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  }
};

var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
barChart.render();

const onTime = {{ $onTimeReturns ?? 0 }};
const late = {{ $lateReturns ?? 0 }};

const donutData = (onTime === 0 && late === 0) 
    ? [1, 1] 
    : [onTime, late];

const donutLabels = (onTime === 0 && late === 0)
    ? ['Belum ada data', 'Belum ada data']
    : ['Tepat Waktu', 'Terlambat'];

var donutOptions = {
  series: donutData,
  chart: {
    type: "donut",
    height: 350
  },
  labels: donutLabels,
  colors: ["#ABCFF3", "#E892C0"], 
  
  stroke: {
    show: true,
    width: 2,
    colors: ['#fff']
  },
  plotOptions: {
    pie: {
      donut: {
        size: "50%", 
      }
    }
  },
  legend: {
    show: false
  },
};

var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
donutChart.render();
</script>
