import ApexCharts from "apexcharts";

// ===== chartThree

function stringToColor(inputString) {
  // Use a simple hash function to generate a unique number for the string
  let hashValue = hashCode(inputString) % 16777216; // 16777216 = 256^3 (total number of RGB colors)

  // Extract the red, green, and blue components from the hash value
  let red = (hashValue >> 16) & 255;
  let green = (hashValue >> 8) & 255;
  let blue = hashValue & 255;

  return `rgb(${red}, ${green}, ${blue})`;
}

function hashCode(str) {
  let hash = 0;
  if (str.length === 0) return hash;
  for (let i = 0; i < str.length; i++) {
    const char = str.charCodeAt(i);
    hash = (hash << 5) - hash + char;
    hash |= 0; // Convert to 32bit integer
  }
  return hash;
}

const createLabel = ({name, percentage, color}) => {
    return `<div class="w-full px-8 sm:w-1/2">
            <div class="flex w-full items-center">
              <span class="mr-2 block h-3 w-full max-w-3 rounded-full" style="background-color: ${color}"></span>
              <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
              <span> ${name} </span>
              <span> ${percentage}% </span>
              </p>
            </div>
          </div>`
}

const chart03 = () => {
  const chartThreeOptions = {
    series: [],
    chart: {
      type: "donut",
      width: 380,
    },
    colors: [],
    labels: [],
    legend: {
      show: false,
      position: "bottom",
    },

    plotOptions: {
      pie: {
        donut: {
          size: "65%",
          background: "transparent",
        },
      },
    },

    dataLabels: {
      enabled: false,
    },
    responsive: [
      {
        breakpoint: 640,
        options: {
          chart: {
            width: 200,
          },
        },
      },
    ],
  };
  const chartSelector = document.querySelectorAll("#chartThree");

  if (chartSelector.length == 0) return;

  fetch('/api/report/donut')
    .then(response => response.json())
    .then(result => {
      if (!Array.isArray(result)) return;
      
       
      if (chartSelector.length) {
		const wrapperLabel = document.getElementById('donut-label')
		const total = result.reduce((n, {total_transaction}) => n + total_transaction, 0)
		result.forEach(item => {
			const color = stringToColor(item.name)
			chartThreeOptions.series.push(item.total_transaction)
			chartThreeOptions.labels.push(item.name)
			chartThreeOptions.colors.push(color)
			wrapperLabel.insertAdjacentHTML('afterbegin', createLabel({
			name: item.name,
			percentage: Math.round((item.total_transaction / total) * 100),
			color,
			}))
		})
        const chartThree = new ApexCharts(
          document.querySelector("#chartThree"),
          chartThreeOptions
        );
        chartThree.render();
      }
    })
  
};

export default chart03;
