import ApexCharts from "apexcharts";
import { forEach } from "lodash";

// ===== chartOne
const chart01 = () => {
  const chartOneOptions = {
	series: [
		{
		  name: "Transaksi Masuk",
		  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
		},
  
		{
		  name: "Transaksi Keluar",
		  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
		},
	],
    legend: {
      show: false,
      position: "top",
      horizontalAlign: "left",
    },
    colors: ["#3C50E0", "#80CAEE"],
    chart: {
      fontFamily: "Satoshi, sans-serif",
      height: 335,
      type: "area",
      dropShadow: {
        enabled: true,
        color: "#623CEA14",
        top: 10,
        blur: 4,
        left: 0,
        opacity: 0.1,
      },

      toolbar: {
        show: false,
      },
    },
    responsive: [
      {
        breakpoint: 1024,
        options: {
          chart: {
            height: 300,
          },
        },
      },
      {
        breakpoint: 1366,
        options: {
          chart: {
            height: 350,
          },
        },
      },
    ],
    stroke: {
      width: [2, 2],
      curve: "straight",
    },

    markers: {
      size: 0,
    },
    labels: {
      show: false,
      position: "top",
    },
    grid: {
      xaxis: {
        lines: {
          show: true,
        },
      },
      yaxis: {
        lines: {
          show: true,
        },
      },
    },
    dataLabels: {
      enabled: false,
    },
    markers: {
      size: 4,
      colors: "#fff",
      strokeColors: ["#3056D3", "#80CAEE"],
      strokeWidth: 3,
      strokeOpacity: 0.9,
      strokeDashArray: 0,
      fillOpacity: 1,
      discrete: [],
      hover: {
        size: undefined,
        sizeOffset: 5,
      },
    },
    xaxis: {
      type: "category",
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      title: {
        style: {
          fontSize: "0px",
        },
      },
      min: 0,
      max: 50,
    },
  };

  const chartSelector = document.querySelectorAll("#chartOne");

  if (chartSelector.length) {
	fetch('/api/report/diagram')
		.then(response => response.json())
		.then(result => {
			if (result == undefined || result == null) return;
			let t_in = [];
			let t_out = []
			Object.values(result.in).forEach((item, index) => {
				t_in.push(item)
			})
			console.log(t_in)
			chartOneOptions.series = [
				{
					name: "Transaksi Masuk",
					data: Object.values(result.in),
				},
				{
					name: "Transaksi Keluar",
					data:  Object.values(result.out),
				},
			]
			const chartOne = new ApexCharts(
			document.querySelector("#chartOne"),
			chartOneOptions
			);
			chartOne.render();
		})
	
  }
};

export default chart01;
