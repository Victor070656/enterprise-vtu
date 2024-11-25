 
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("transchart.php",
                function (data)
                {
                    console.log(data);
                     var network = [];
                    var amount = [];
                    var date = [];

                    for (var i in data) {
                        network.push(data[i].network);
                        amount.push(data[i].amount);
                        date.push(data[i].date);
                    }

                    var chartdata = {
                        labels: network,
                        date: date,
                        datasets: [
                            {
                                label: 'Amount',
                                backgroundColor: 'transparent',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: amount
                            }
                            
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
                        responsive : true,
                         options: {
     scales: {
       yAxes: [{
         ticks: {
           callback: function(value, index, values) {
             return value.toLocaleString("en-NG",{style:"currency", currency:"NGN"});
           }
         }
       }]
     }
   }
                    });
                    
                    setInterval(function(){
    $('#graphCanvas').load('transchart.php')},1000); //every 3 sec
  

                });
            }
        }
    