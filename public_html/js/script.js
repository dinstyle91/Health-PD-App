// Our labels along the x-axis
var years = ['18 Sept','19 Sept','20 Sept','21 Sept','22 Sept','23 Sept','24 Sept','25 Sept','26 Sept','27 Sept','28 Sept'];
// For drawing the lines
var patient = [0,2,3,6,4,4,5,6,8,5,5];

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: years,
    datasets: [
      { 
        data: patient,
        label: "Sessions",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  }
});