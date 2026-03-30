<script>
const labels = @json($allMonths);
const data = @json($chartData);

const smartLibNavy = '#1e1e1e'; 
const smartLibGold = '#ad9a79';    

var barOptions = {
  series: [{
    name: "Total Transaksi",
    data: data
  }],
  chart: {
    type: "bar",
    height: 250,
    toolbar: { show: false }
  },

  colors: [smartLibNavy], 
  plotOptions: {
    bar: {
      borderRadius: 6,
      columnWidth: "35%", 
      distributed: false,
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      type: "vertical",
      gradientToColors: [smartLibGold], 
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 0.9,
    }
  },
  xaxis: {
    categories: labels,
    axisBorder: { show: false },
    axisTicks: { show: false },
    labels: {
      style: {
        colors: '#8e8e8e',
        fontFamily: 'DM Sans, sans-serif'
      }
    }
  },
  yaxis: {
    min: 0,
    labels: {
      style: { colors: '#8e8e8e' }
    }
  },
  grid: {
    borderColor: '#f4f4f4',
    strokeDashArray: 4,
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
    height: 280 
  },
  labels: donutLabels,
 
  colors: [ smartLibGold, smartLibNavy], 
  
  stroke: {
    show: true,
    width: 3,
    colors: ['#fff']
  },
  plotOptions: {
    pie: {
      donut: {
        size: "70%", 
        labels: {
            show: true,
            total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                    return (onTime + late);
                }
            }
        }
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + " Buku";
      }
    }
  }
};

var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
donutChart.render();
</script>