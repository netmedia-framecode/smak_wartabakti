// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("chart-dashboard");
var categories = Array.from(new Set(dataGrafik.map((item) => item.category))); // Mendapatkan daftar unik dari kategori

var datasets = categories.map((category, index) => {
  return {
    label: `${category}`, // Menambahkan kategori ke dalam label
    backgroundColor: getBackgroundColor(index),
    hoverBackgroundColor: getHoverBackgroundColor(index),
    borderColor: getBorderColor(index),
    borderWidth: 1,
    data: [{
      x: `${category}`, // Menggunakan label kategori sebagai posisi pada sumbu x
      y: dataGrafik
        .filter((item) => item.category === category)
        .map((item) => item.total)[0], // Hanya mengambil satu data karena kita telah mengelompokkan berdasarkan kategori
    }],
  };
});

var myBarChart = new Chart(ctx, {
  type: "bar",
  data: {
    datasets: datasets,
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0,
      },
    },
    scales: {
      x: {
        type: 'category', // Menetapkan tipe skala menjadi kategori
        grid: {
          display: false,
          drawBorder: false,
        },
        labels: categories, // Menetapkan label pada sumbu x
      },
      y: {
        position: 'left',
        grid: {
          display: false,
        },
        ticks: {
          beginAtZero: true,
        },
      },
    },
    plugins: {
      legend: {
        display: true,
      },
      tooltip: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || "";
            var value = chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].y;
            return datasetLabel + ": " + number_format(value);
          },
        },
      },
    },
  },
});

function getBackgroundColor(index) {
  // Menghasilkan warna latar belakang berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 0.5)",
    "rgba(255, 99, 132, 0.5)",
    "rgba(54, 162, 235, 0.5)",
    "rgba(255, 205, 86, 0.5)",
  ];
  return colors[index % colors.length];
}

function getHoverBackgroundColor(index) {
  // Menghasilkan warna latar belakang hover berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 0.7)",
    "rgba(255, 99, 132, 0.7)",
    "rgba(54, 162, 235, 0.7)",
    "rgba(255, 205, 86, 0.7)",
  ];
  return colors[index % colors.length];
}

function getBorderColor(index) {
  // Menghasilkan warna garis batas berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 1)",
    "rgba(255, 99, 132, 1)",
    "rgba(54, 162, 235, 1)",
    "rgba(255, 205, 86, 1)",
  ];
  return colors[index % colors.length];
}